<?php

namespace App\Http\Controllers\FilesUI;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\FilesData\SuppliersDAL;
use App\Models\Suppliers;

class SuppliersUI extends Controller
{
    public function SaveEditSuppliers(Request $request)
    {
        // $request['SupplierId'] = 'CT1012';
        // $request['SupplierName'] = 'peds';
        // $request['Address'] = 'CORDOVA';
        // $request['ContactPerson'] = 'peter';
        // $request['ContactNo'] = '09099909';
        
       $supplier = (new SuppliersDAL)->GeSuppliersId($request->SupplierId);

        if($supplier)
        {
            $supplier->update($request->all());
            return response()->json(['message'=>'updated'],200);
        }
        else
        {
            (new SuppliersDAL)->SaveSuppliers($request->all());
            return response()->json(['message'=>'saved!'],200);
            
        }

    }
    public function DeleteSupplier($supplierId)
    {
        $supplier = (new SuppliersDAL)->GeSuppliersId($supplierId);
        if($supplier){
            $supplier->delete();
            return response()->json(['message' => 'Supplier deleted successfully'],200);
        }
        else{
            return response()->json(['error' => 'Supplier not found'], 404);
        }
    }
}
