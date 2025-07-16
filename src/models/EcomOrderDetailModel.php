<?php
namespace Src\Models;

class EcomOrderDetailModel extends BaseModel
{
    protected string $table      = 'jacques_EcomOrderDetail';
    protected string $primaryKey = 'OrderDetailID';

    protected array $searchable = [
        'OrderID',
        'ProductID',
        'ProductQty',
    ];
}