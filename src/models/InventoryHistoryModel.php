<?php
namespace Src\Models;

class InventoryHistoryModel extends BaseModel
{
    protected string $table      = 'jacques_InventoryHistory';
    protected string $primaryKey = 'InventoryHistoryID';

    protected array $searchable = [
        'InventoryID',
        'OrderDetailID',
        'ChangeQty',
    ];
}