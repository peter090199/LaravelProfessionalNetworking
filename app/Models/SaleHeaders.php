<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleHeaders extends Model
{
    use HasFactory;
    protected $table='saleheaders';
    protected $fillable = [
        'ReceiptNo',
        'TransDate',
        'TransDateTime',
        'CustomerId',
        'CustomerName',
        'Address',
        'ContactNo',
        'TotalAmount',
        'Discount',
        'DiscountValue',
        'DiscountType',
        'TotalDue',
        'AmountPaid',
        'PaymentType',
        'RecordStatus',
        'TransNo',
        'TransStatus',
        'RecordStatus'
    ];
}
