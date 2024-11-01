<?php

namespace App\Http\Controllers\SalesUI;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\SalesData\SalesHeadersDAL;
use App\Http\Controllers\SalesData\SalesDetailsDAL;

class SalesReceiptUI extends Controller
{
    public function UpdateSaleHeaderStatusByReceiptNo($ReceiptNo, $RecordStatus){
        $SaleHeader     = (new SalesHeadersDAL)->GetSaleHeaderByReceiptNo($ReceiptNo);
        $SaleDetails    = (new SalesDetailsDAL)->GetSaleDetailsByReceiptNo($ReceiptNo);

        $SaleHeader->update(['RecordStatus' => $RecordStatus]);
        foreach($SaleDetails as $SaleDetail){
            $SaleDetail->update(['RecordStatus' => $RecordStatus]);
            (new EditSaleRecordUI)->AdjustInventory($SaleDetail);
        }
        (new SharedSalesRoutine)->UpdateSaleHeaderAmount($SaleHeader->ReceiptNo);
        return response()->json(['message' => 'Successfully '.$RecordStatus],200);
    }




}
