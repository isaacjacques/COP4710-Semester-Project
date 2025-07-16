<?php
namespace Src\Models;

class ProductModel extends BaseModel
{
    protected string $table = 'jacques_Product';
    protected string $primaryKey = 'ProductID';

    protected array $searchable = [
        'SKU', 'UPC', 'Color', 'Size', 'Brand'
    ];
}