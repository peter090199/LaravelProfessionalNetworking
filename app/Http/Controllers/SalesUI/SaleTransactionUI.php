<?php

namespace App\Http\Controllers\SalesUI;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\SalesData\SalesHeadersDAL;
use App\Http\Controllers\SalesData\SalesDetailsDAL;
use App\Http\Controllers\FilesData\ItemsDAL;
use App\Http\Controllers\ConfigData\ControlNumbersDAL;
use App\Http\Controllers\FilesData\CustomersDAL;
use App\Models\SaleHeaders;

use Carbon\Carbon;

class SaleTransactionUI extends Controller
{
    public function SaveToSaleHeaders($ItemId, $TransNo, $CustomerId){
        $SaleHeader     = (new SalesHeadersDAL)->GetSaleHeaderByTransNo($TransNo);
        $SaleHeaderData = $this->GetSaleHeaderData($TransNo, $CustomerId);
        if($SaleHeader)
            $SaleHeader->update($SaleHeaderData);
        else
            $SaleHeader = (new SalesHeadersDAL)->SaveData($SaleHeaderData);

        return $this->SaveToSaleDetails($ItemId, $TransNo, $CustomerId);
    }
    
    public function SaveToSaleDetails($ItemId, $TransNo, $CustomerId){
        $Item           = (new ItemsDAL)->GetItemsByItemId($ItemId);
        $SaleDetail     = (new SalesDetailsDAL)->GetSaleDetailByItemIdByTransNoByPrice($ItemId, $TransNo, $Item->Price);
        if($SaleDetail){
            $SaleDetail->increment('Qty', 1);
        }else{
            $SaleDetailData = $this->GetSaleDetailData($Item, $TransNo, $CustomerId);
            $SaleDetail = (new SalesDetailsDAL)->SaveData($SaleDetailData);
        }
        return response()->json(['message' => 'Successfully Saved!'],200);
    }

    public function UpdateElementSaleDetail($Id, $Column, $Value){
        $SaleDetail     = (new SalesDetailsDAL)->GetSaleDetailById($Id);
        if($SaleDetail){
            $SaleDetail->update([$Column => $Value]);

            $Discount = $SaleDetail->DiscountValue;
            if($SaleDetail->DiscountType == 'percent'){
                $Discount = $SaleDetail->DiscountValue/100 * $SaleDetail->Price;
            }
            $SaleDetail->update(['Discount' => $Discount ]);
        }
        return response()->json(['message' => 'Successfully Updated!'],200);
    }
    public function UpdateSaleDetail(Request $request){
        $SaleDetail = (new SalesDetailsDAL)->GetSaleDetailById($request->id);
        
        if($SaleDetail){
            $SaleDetail->update($request->all());
        }
        return response()->json(['message' => 'Successfully Updated!'], 200);
    }
    public function UpdateSaleHeader($ForAction, Request $request)
    {
        $ReceiptNo      = $request->ReceiptNo;
        if($ReceiptNo == "generated"){
            do
            {
                $ReceiptNo= (new ControlNumbersDAL)->GenerateId("SaleNo", "PSaleNo");
                (new ControlNumbersDAL)->IncrementControlNumber('SaleNo');
                $record = (new SalesHeadersDAL)->GetSaleHeaderByReceiptNo($ReceiptNo);
            } while ($record != null);
        }

        $SaleHeader         = (new SalesHeadersDAL)->GetSaleHeaderByTransNo($request->TransNo);
        $SaleDetails        = (new SalesDetailsDAL)->GetSaleDetailsByTransNoNotVoid($request->TransNo);
        $Customer           = $this->GetCustomerData($request);
        $SaleHeaderData     = $this->GetSaleHeaderData2($request, $ReceiptNo, $Customer, $SaleHeader, $ForAction);

        $SaleHeader->update($SaleHeaderData);

        (new EditSaleRecordUI)->UpdateDetails($SaleHeader, $SaleDetails, $ForAction);

        if($ForAction == "open"){
            (new ControlNumbersDAL)->IncrementControlNumber('TransSaleNo') ;
            return response()->json(['message' => 'Successfully Save!']);
        }
        if($ForAction == "update"){
            return response()->json(['message' => 'Successfully Updated!']);
        }
    }
    
    public function GetSaleHeaderData($TransNo, $CustomerId){
        $data = [
            'TransDate'     => Carbon::now()->toDateString(),
            'TransDateTime' => Carbon::now()->toDateTimeString(),
            'CustomerId'    => $CustomerId,
            'TransNo'       => $TransNo,
        ];
        return $data;
    }

    public function GetSaleDetailData($Item, $TransNo, $CustomerId){
        $data = [
            'TransDate'     => Carbon::now()->toDateString(),
            'TransDateTime' => Carbon::now()->toDateTimeString(),
            'CustomerId'    => $CustomerId,
            'TransNo'       => $TransNo,
            'ItemId'        => $Item->ItemId,
            'ItemName'      => $Item->ItemName,
            'UM'            => $Item->UM,
            'Category'      => $Item->Category,
            'Price'         => $Item->Price,
            'Qty'           => 1,
        ];
        return $data;
    }
    public function GetCustomerData(Request $request){
        $Customer = [];
        if($request->CustomerId == "CASH"){
            $Customer = [
                'CustomerId'     => "CASH",
                'CustomerName'   => "CASH",
                'Address'        => "CASH",
                'ContactNo'      => "CASH",
            ];
        }
        else{
            $Customer           = (new CustomersDAL)->GetCustomerByCustomerId($request->CustomerId);
            $Customer = [
                'CustomerId'     => $Customer->CustomerId,
                'CustomerName'   => $Customer->CustomerName,
                'Address'        => $Customer->Address,
                'ContactNo'      => $Customer->ContactNo,
            ];
        }

        return (object)$Customer;
    }

public function GetSaleHeaderData2(Request $request, $ReceiptNo, $Customer, $SaleHeader, $ForAction){
        $ForAction          = ( $ForAction == 'update') ? $SaleHeader->RecordStatus : $ForAction;
        $data = [
            'ReceiptNo'        => $ReceiptNo,
            'TransDate'        => $request->TransDate,
            'TransDateTime'    => $request->TransDate.' '.Carbon::now()->toTimeString(),
            'CustomerId'       => $Customer->CustomerId,
            'CustomerName'     => $Customer->CustomerName,
            'Address'          => $Customer->Address,
            'ContactNo'        => $Customer->ContactNo,
            'TotalAmount'      => $request->TotalAmount,
            'Discount'         => $request->Discount,
            'DiscountValue'    => $request->DiscountValue,
            'DiscountType'     => $request->DiscountType,
            'TotalDue'         => $request->TotalDue,
            'AmountPaid'       => $request->AmountPaid,
            'PaymentType'      => $request->PaymentType,
            'RecordStatus'     => $ForAction,
            'TransStatus'      => 'finish',
        ];

        return  $data;
    }


}
