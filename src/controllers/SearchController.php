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
}