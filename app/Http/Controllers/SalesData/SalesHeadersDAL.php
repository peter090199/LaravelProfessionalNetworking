<?php

namespace App\Http\Controllers\SalesData;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SaleHeaders;
use App\Models\SaleDetails;
use DB;

class SalesHeadersDAL extends Controller
{
    public function GetSaleHeaderByTransNo($sh){
        return SaleHeaders::where('TransNo',$sh)->first();
    
    }
    public function GetSaleHeaderByReceiptNo($sh){
        return SaleHeaders::where('ReceiptNo',$sh)->first();
    
    }
    public function GetHeaderById($Id){
        return SaleHeaders::find($Id);
    }
    public function SaveData($data){
        return SaleHeaders::create($data);
    }

    public function GetSaleHeaderByTransDateFromByTransDateTo($TransDateFrom, $TransDateTo){
        return SaleHeaders::select(
                                    'id',
                                    'ReceiptNo',
                                    'TransDate',
                                    'CustomerId',
                                    'CustomerName',
                                    'Address',
                                    'ContactNo',
                                    'TotalAmount',
                                    'Discount',
                                    'TotalDue',
                                    'AmountPaid',
                                    'PaymentType',
                                    'RecordStatus',
                             )
                            ->whereBetween('TransDate', [$TransDateFrom, $TransDateTo])
                            ->get();
    }
   
    // public function UpdateSaleHeaderStatusByReceiptNo($ReceiptNo, $RecordStatus)
    // {
    //     $saleHeader = SaleHeaders::where('ReceiptNo', $ReceiptNo)->first();
    //     if (!$saleHeader) {
    //         return response()->json(['error' => 'Sale header not found'], 404);
    //     }
    //     $saleHeader->update(['RecordStatus' => $RecordStatus]);
    //     SaleDetails::where('ReceiptNo', $ReceiptNo)->update(['RecordStatus' => $RecordStatus]);
    //     return response()->json(['message' => 'Sales header status updated successfully']);
    // }

    public function UpdateSaleHeaderStatusByReceiptNo($ReceiptNo, $RecordStatus){
        $SaleHeader     = (new SaleHeadersDAl)->GetSaleHeaderByReceiptNo($ReceiptNo);
        $SaleDetails    = (new SaleDetailsDAL)->GetSaleDetailsByReceiptNo($ReceiptNo);

        $SaleHeader->update(['RecordStatus' => $RecordStatus]);
        foreach($SaleDetails as $SaleDetail){
            $SaleDetail->update(['RecordStatus' => $RecordStatus]);
            (new EditSaleRecordUI)->AdjustInventory($SaleDetail);
        }
        (new SharedSalesRoutine)->UpdateSaleHeaderAmount($SaleHeader->ReceiptNo);
        return response()->json(['message' => 'Successfully '.$RecordStatus],200);
    }
    public function ReComputeDiscount($ReceiptNo){
        SaleHeaders::where('ReceiptNo',$ReceiptNo)->update(['Discount'=>DB::raw(''.$this->DiscountAmount().'')]);
                   
    }
   function DiscountAmount(){
    return $this->TotalAmount().'*'.$this->DiscountPercent();
   }
   function TotalAmount(){
    return 'TotalAmount';
   }
   function DiscountPercent(){
    return 'DiscountValue/100';
   }



}
