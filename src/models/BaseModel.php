<?php
namespace Src\Models;

use PDO;

abstract class BaseModel
{
    protected PDO $pdo;
    protected string $table;
    protected string $primaryKey = 'id';
    protected array $searchable = [];
    protected array $timestamps = ['CreationTime'];
    protected array $columns; 

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getSearchable(): array
    {
        return $this->searchable;
    }
    
    public function getPrimaryKey(): string
    {
        return $this->primaryKey;
    }

    public function search(array $criteria): array
    {
        $where = [];
        $params = [];
        foreach ($criteria as $col => $val) {
            if (in_array($col, $this->searchable, true) && $val !== '') {
                $where[] = "`$col` LIKE :$col";
                $params[":$col"] = "%$val%";
            }
        }
        $sql = 'SELECT * FROM `' . $this->table . '`'
             . (count($where) ? ' WHERE ' . implode(' AND ', $where) : '');
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById($id): ?array
    {
        $sql  = "SELECT * FROM `{$this->table}` WHERE `{$this->primaryKey}` = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row !== false ? $row : null;
    }
    
    public function getColumns(): array
    {
        if (!isset($this->columns)) {
            $stmt = $this->pdo->query("DESCRIBE `{$this->table}`");
            $this->columns = array_map(fn($c) => $c['Field'], $stmt->fetchAll(PDO::FETCH_ASSOC));
        }
        return $this->columns;
    }

    public function getFormFields(): array
    {
        return array_filter(
            $this->getColumns(),
            fn($col) => !in_array($col, $this->timestamps, true)
        );
    }

    public function insert(array $data): int
    {
        $fields = array_intersect(array_keys($data), $this->getFormFields());
        $placeholders = array_map(fn($f) => ":{$f}", $fields);

        $sql = sprintf(
            "INSERT INTO `%s` (%s) VALUES (%s)",
            $this->table,
            implode(',', $fields),
            implode(',', $placeholders)
        );
        $stmt = $this->pdo->prepare($sql);
        foreach ($fields as $f) {
            $stmt->bindValue(":{$f}", $data[$f]);
        }
        $stmt->execute();

        if (in_array($this->primaryKey, $fields, true) === false) {
            return (int)$this->pdo->lastInsertId();
        }
        return (int)$data[$this->primaryKey];
    }

    public function updateById($id, array $data): bool
    {
        $fields = array_filter(
            $this->getFormFields(),
            fn($col) => $col !== $this->primaryKey
        );
        $sets = array_map(fn($f) => "`{$f}` = :{$f}", $fields);

        $sql = sprintf(
            "UPDATE `%s` SET %s WHERE `%s` = :_pk",
            $this->table,
            implode(', ', $sets),
            $this->primaryKey
        );
        $stmt = $this->pdo->prepare($sql);
        foreach ($fields as $f) {
            $stmt->bindValue(":{$f}", $data[$f]);
        }
        $stmt->bindValue(":_pk", $id);
        return $stmt->execute();
    }

    public function deleteById($id): bool
    {
        $sql = "DELETE FROM `{$this->table}` WHERE `{$this->primaryKey}` = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}