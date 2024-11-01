<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Items extends Model
{
    use HasFactory;
    protected $table='items';
    protected $fillable = [
        'ItemId',
        'ItemName',
        'Available',
        'Price',
        'Cost',
        'UM',
        'Category',
        'RecordStatus'
    ];
}
