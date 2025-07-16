<?php
require __DIR__ . '/../vendor/autoload.php';

$config = require __DIR__ . '/../config/config.php';
$dsn = sprintf(
    'mysql:host=%s;dbname=%s;charset=%s',
    $config['host'],
    $config['dbname'],
    $config['charset']
);

$pdo = new PDO(
    $dsn,
    $config['user'],
    $config['password'],
    [ PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ]
);

use Src\Controllers\SearchController;

$ctrl   = new SearchController($pdo);
$action = $_GET['action'] ?? 'index';

if ($action === 'search') {
    $ctrl->search();
} elseif ($action === 'view') {
    $ctrl->view();
} else {
    $ctrl->index();
}