<?php
namespace Src\Controllers;

use Src\Models\ProductModel;
use Src\Models\CustomerModel;
use Src\Models\CustomerCartModel;
use Src\Models\EcomOrderModel;
use Src\Models\EcomOrderDetailModel;
use Src\Models\InventoryModel;
use Src\Models\InventoryHistoryModel;
use PDO;
use PDOException;

class SearchController
{
    private PDO $pdo;
    
    private array $models = [
        'Product'               => ProductModel::class,
        'Customer'              => CustomerModel::class,
        'CustomerCart'          => CustomerCartModel::class,
        'EcomOrder'             => EcomOrderModel::class,
        'EcomOrderDetail'       => EcomOrderDetailModel::class,
        'Inventory'             => InventoryModel::class,
        'InventoryHistory'      => InventoryHistoryModel::class,
    ];

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function index(): void
    {
        $tables = [];
        foreach ($this->models as $name => $class) {
            $m = new $class($this->pdo);
            $tables[$name] = $m->getSearchable();
        }
        require __DIR__ . '/../views/search_form.php';
    }

    public function search(): void
    {
        $table = $_GET['table'] ?? '';
        $criteria = $_GET['criteria'] ?? [];
        if (!isset($this->models[$table])) {
            die('Unknown table');
        }
        $class = $this->models[$table];
        $model = new $class($this->pdo);
        $results = $model->search($criteria);

        $_SESSION['last_search_url'] = 
            'index.php?action=search&' . http_build_query([
                'table'    => $table,
                'criteria' => $_GET['criteria'] ?? []
            ]);

        require __DIR__ . '/../views/search_results.php';
    }

    public function view(): void
    {
        $table = $_GET['table'] ?? '';
        $id    = $_GET['id']    ?? '';
        if (! isset($this->models[$table]) || $id === '') {
            die('Invalid request');
        }

        $class = $this->models[$table];
        $model  = new $class($this->pdo);
        $record = $model->findById($id);

        if ($record === null) {
            die('Record not found');
        }

        require __DIR__ . '/../views/detail.php';
    }
    
    public function add(): void
    {
        $table = $_GET['table'] ?? '';
        $class = $this->validateTable($table);
        $model = new $class($this->pdo);

        $fields = $model->getFormFields();
        $data   = [];
        $errors = [];

        require __DIR__ . '/../views/change_form.php';
    }

    public function edit(): void
    {
        $table = $_GET['table'] ?? '';
        $id    = $_GET['id']    ?? '';
        $class = $this->validateTable($table);

        $model = new $class($this->pdo);
        $record = $model->findById($id) 
            or die('Record not found');

        $fields = $model->getFormFields();
        $data   = $record;
        $errors = [];

        require __DIR__ . '/../views/change_form.php';
    }

    public function create(): void
    {
        $table  = $_POST['table']  ?? '';
        $class  = $this->validateTable($table);
        $model  = new $class($this->pdo);

        $fields = $model->getFormFields();
        $data   = $_POST['fields'] ?? [];
        $errors = $this->validate($fields, $data);

        if ($errors) {
            require __DIR__ . '/../views/change_form.php';
            return;
        }

        try {
            $model->insert($data);
            $back = $_SESSION['last_search_url'] ?? 'index.php';
            header("Location: {$back}");
            exit;
        } catch (PDOException $e) {
            $errors['_general'] = 'Unable to create record: ' . $e->getMessage();
            require __DIR__ . '/../views/change_form.php';
        }
    }

    public function update(): void
    {
        $table  = $_POST['table'] ?? '';
        $id     = $_POST['id']    ?? '';
        $class  = $this->validateTable($table);
        $model  = new $class($this->pdo);

        $fields = $model->getFormFields();
        $data   = $_POST['fields'] ?? [];
        $errors = $this->validate($fields, $data);

        if ($errors) {
            require __DIR__ . '/../views/change_form.php';
            return;
        }

    try {
        $model->updateById($id, $data);
        header("Location: index.php?action=view&table={$table}&id={$id}");
        exit;
    } catch (PDOException $e) {
        $errors['_general'] = 'Unable to update record: ' . $e->getMessage();
        require __DIR__ . '/../views/change_form.php';
    }
    }

    public function delete(): void
    {
        $table = $_GET['table'] ?? '';
        $id    = $_GET['id']    ?? '';
        $class = $this->validateTable($table);

        $model = new $class($this->pdo);
        $model->deleteById($id);

        $back = $_SESSION['last_search_url'] ?? 'index.php';
        header("Location: {$back}");
        exit;
    }

    private function validateTable(string $table): string
    {
        if (! isset($this->models[$table])) {
            die('Invalid table');
        }
        return $this->models[$table];
    }

    private function validate(array $fields, array $data): array
    {
        $errors = [];
        foreach ($fields as $f) {
            if (($data[$f] ?? '') === '') {
                $errors[$f] = "{$f} is required";
            }
        }
        return $errors;
    }
}