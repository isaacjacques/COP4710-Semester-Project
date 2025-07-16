<?php
namespace Src\Models;

class InventoryModel extends BaseModel
{
    protected string $table      = 'jacques_Inventory';
    protected string $primaryKey = 'InventoryID';

    protected array $searchable = [
        'InventoryStatus',
        'ProductID',
        'LPN',
    ];
}