<?php

namespace App\Http\Controllers\FilesData;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Suppliers;

class SuppliersDAL extends Controller
{
    public function GetSuppliers(){
        return Suppliers::all();
     // return 123;
    }
    public function GeSuppliersId($supplierId){
        return Suppliers::where('SupplierId',$supplierId)->first();
    }

    public function SaveSuppliers($data){
        return Suppliers::create($data);  
    }
}
