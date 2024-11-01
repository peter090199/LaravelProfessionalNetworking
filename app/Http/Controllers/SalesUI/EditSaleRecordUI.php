<?php

namespace App\Http\Controllers\SalesUI;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\FilesData\ItemsDAL;
use App\Http\Controllers\SalesData\SalesHeadersDAL;
use App\Http\Controllers\SalesData\SalesDetailsDAL;
use App\Models\SaleDetails;

class EditSaleRecordUI extends Controller
{
    public function GetSaleDetailsByTransDateFromByTransDateTo($dtFrom,$dtTo){
        return SaleDetails::whereBetween('TransDate',[$dtFrom,$dtTo])->get();
    }

    public function UpdateDetails($SaleHeader,$SaleDetails, $ForAction){
        foreach($SaleDetails as $SaleDetail){
           if($SaleDetail->RecordStatus != 'void'){
               $SaleDetailsData = $this->GetSaleDetailUpdateFromSaleHeader($SaleHeader);
               $SaleDetail->update($SaleDetailsData);
               if($ForAction == 'open')
                   $this->UpdateAffectedByOldDataByNewData(null, $SaleDetail);
           }
       }
   }
   public function UpdateAffectedByOldDataByNewData($OldData, $SaleDetail){
    $Item = (new ItemsDAL)->GetItemsByItemId($SaleDetail->ItemId);
    if($OldData){
        $Item->increment('Available', $OldData->Qty);
    }
    $Item->decrement('Available', $SaleDetail->Qty);
}
public function GetSaleDetailUpdateFromSaleHeader($SaleHeader){
    $data = [
        'ReceiptNo'         => $SaleHeader->ReceiptNo,
        'TransDate'         => $SaleHeader->TransDate,
        'TransDateTime'     => $SaleHeader->TransDateTime,
        'CustomerId'        => $SaleHeader->CustomerId,
        'CustomerName'      => $SaleHeader->CustomerName,
        'RecordStatus'      => $SaleHeader->RecordStatus,
        'TransStatus'       => $SaleHeader->TransStatus,
    ];
    return $data;
}

    public function AdjustInventory($SaleDetail){
        $Item = (new ItemsDAL)->GetItemsByItemId($SaleDetail->ItemId);
        if($SaleDetail->RecordStatus == 'void')
            $Item->increment('Available', $SaleDetail->Qty);
    else
            $Item->decrement('Available', $SaleDetail->Qty);
    }




}
