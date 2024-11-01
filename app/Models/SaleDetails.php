<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleDetails extends Model
{
    use HasFactory;
    protected $table='saledetails';
    protected $fillable = [
        'ReceiptNo',
        'TransDate',
        'TransDateTime',
        'CustomerId',
        'CustomerName',
        'ItemId',
        'ItemName',
        'UM',
        'Category',
        'Price',
        'Qty',
        'Discount',
        'DiscountType', 
        'RecordStatus',
        'TransNo',
        'TransStatus',
       
    ];
    
}
