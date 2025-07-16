<?php
namespace Src\Models;

use PDO;

abstract class BaseModel
{
    protected PDO $pdo;
    protected string $table;
    protected string $primaryKey = 'id';
    protected array $searchable = [];

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
}