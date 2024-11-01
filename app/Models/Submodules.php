<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Submodules extends Model
{
    use HasFactory;
    protected $table='submodules';
    protected $fillable = [
        'SubModule',
        'ModuleId',
        'Route',
        'RecordStatus',
       
    ];
}
