<?php

namespace App\Http\Controllers\SalesUI;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\SalesData\SalesHeadersDAL;
use App\Http\Controllers\SalesData\SalesDetailsDAL;

class SharedSalesRoutine extends Controller
{
    public function UpdateSaleHeaderAmount($ReceiptNo)
    {
        $SaleHeader  = (new SalesHeadersDAL)->GetSaleHeaderByReceiptNo($ReceiptNo);
        $totalAmount = (new SalesDetailsDAL)->ComputeTotalAmount($ReceiptNo);
        $SaleHeader->update(['TotalAmount' => $totalAmount]);

        if ($SaleHeader->DiscountType == "percent"){
            (new SalesHeadersDAL)->ReComputeDiscount($ReceiptNo);
        }
      
        $totalDue = $totalAmount -  $SaleHeader->Discount;
        $SaleHeader->update(['TotalDue' => $totalDue]);
    }


}
