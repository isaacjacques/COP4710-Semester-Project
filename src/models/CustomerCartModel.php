<?php
namespace Src\Models;

class CustomerCartModel extends BaseModel
{
    protected string $table      = 'jacques_CustomerCart';
    protected string $primaryKey = 'CartItemID';

    protected array $searchable = [
        'CustomerID',
        'ProductID',
        'ProductQty',
    ];
}