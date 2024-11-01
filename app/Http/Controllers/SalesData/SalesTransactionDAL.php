<?php

namespace App\Http\Controllers\SalesData;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SaleHeaders;
use App\Http\Controllers\ConfigData\ControlNumbersDAL;

class SalesTransactionDAL extends Controller
{
    
    public function GetTransSaleNo(){
        $sh = SaleHeaders::where('TransStatus','ongoing')->first();
    
        if($sh)
        {
            return response()->json($sh->TransNo,200);
        }
        else
        {
            $tr =  (new ControlNumbersDAL)->GenerateId('TransSaleNo','PTransSaleNo');
            return response()->json($tr,200);
        }
    }
   

}
