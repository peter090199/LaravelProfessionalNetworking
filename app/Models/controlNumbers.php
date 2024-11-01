<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class controlNumbers extends Model
{
    use HasFactory;
    protected $table = 'controlnumbers';
    protected $fillable = [
        'PItemId',
        'ItemId',
        'PCustomerId',
        'CustomerId',
        'PSupplierId',
        'SupplierId',
        'PSaleNo',
        'SaleNo',
        'PTransSaleNo',
        'TransSaleNo',
    ];

}
