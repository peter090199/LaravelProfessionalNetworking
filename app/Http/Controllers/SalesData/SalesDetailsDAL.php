<?php

namespace App\Http\Controllers\SalesData;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SaleDetails;
use DB;

class SalesDetailsDAL extends Controller
{
   
    public function GetSaleDetailsByTransNo($sh){
        return SaleDetails::where('TransNo',$sh)->get();
    
    }
    
    public function GetSaleDetailsByReceiptNo($sh){
        return SaleDetails::where('ReceiptNo',$sh)->get();
    
    }

    public function GetSaleDetailsByTransNoNotVoid($sh){
        return SaleDetails::where('TransNo',$sh)->where('RecordStatus','!=','void')->get();
    
    }
    public function DeleteSaleDetailById($Id){
        if($Id){
            $Id->delete();
            return response()->json(['message' => 'Items deleted successfully'],200);
        }
        else{
            return response()->json(['error' => 'Items not found'], 404);
        }
    }
    public function GetSaleDetailById($Id){
        return SaleDetails::find($Id);
    }

    public function GetSaleDetailByItemIdByTransNo($ItemId, $TransNo){
        return SaleDetails::where('TransNo', $TransNo)
                        ->where('ItemId', $ItemId)
                        ->first();
    }
    public function GetSaleDetailByItemIdByTransNoByPrice($ItemId, $TransNo,$Price){
        return SaleDetails::where('TransNo', $TransNo)
                        ->where('ItemId', $ItemId)
                        ->where('Price', $Price)
                        ->first();
    }

    public function SaveData($data){
        return SaleDetails::create($data);
    }
    public function ComputeTotalAmount($ReceiptNo){
        return SaleDetails::where('ReceiptNo', $ReceiptNo)
                        ->where('RecordStatus','open')
                       ->sum(DB::raw(''.$this->Amount().''));
    }
    function Amount()
    {
        return $this->PriceAmount().'-'.$this->DiscountAmount();
    }
    function PriceAmount(){
        return 'Price*Qty';
    }
    function DiscountAmount(){
        return 'Discount*Qty';
    }

}
