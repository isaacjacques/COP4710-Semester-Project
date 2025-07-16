<?php
session_start(); 
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

switch ($action) {
  case 'search':  $ctrl->search();  break;
  case 'view':    $ctrl->view();    break;
  case 'add':     $ctrl->add();     break;
  case 'edit':    $ctrl->edit();    break;
  case 'create':  $ctrl->create();  break;
  case 'update':  $ctrl->update();  break;
  case 'delete':  $ctrl->delete();  break;
  default:        $ctrl->index();   break;
}