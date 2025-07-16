<?php
namespace Src\Models;

class CustomerModel extends BaseModel
{
    protected string $table      = 'jacques_Customer';
    protected string $primaryKey = 'CustomerID';

    protected array $searchable = [
        'FirstName',
        'LastName',
        'Email',
    ];
}