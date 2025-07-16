<?php
namespace Src\Models;

class EcomOrderModel extends BaseModel
{
    protected string $table      = 'jacques_EcomOrder';
    protected string $primaryKey = 'OrderID';

    protected array $searchable = [
        'OrderStatus',
        'CustomerID',
        'CreationTime',
    ];
}