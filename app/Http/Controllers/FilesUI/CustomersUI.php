<?php

namespace App\Http\Controllers\FilesUI;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\FilesData\CustomersDAL;
use App\Http\Controllers\ConfigData\ControlNumbersDAL;
use App\Models\Customers;

class CustomersUI extends Controller
{
    public function SaveEditCustomers(Request $request){
        $customer  =  (new CustomersDAL)->GetCustomersId($request['CustomerId']); 
           if ($request['CustomerId']  == 'generated') {
               do
               {
                   $request['CustomerId']  =  (new ControlNumbersDAL)->GenerateId('CustomerId','PCustomerId');
                   (new ControlNumbersDAL)->IncrementControlNumber('CustomerId');
                   $record = (new CustomersDAL)->GetCustomersId($request['CustomerId']);
               } while ($record != null);
           }
     
           if($customer){
               if ($customer->CustomerId != $request->CustomerId){
                   if ((new CustomersDAL)->IsDuplicate('CustomerId', $request->CustomerId)){
                       (new ControlNumbersDAL)->DecrementControlNumber('CustomerId',1);
                       return response()->json(['message'=>'Customer '.$request->CustomerId.' existed already!'],404);
                   } 
               }
               if ($customer->CustomerName != $request->CustomerName){
                   if ((new CustomersDAL)->IsDuplicate('CustomerName', $request->CustomerName)){
                       (new ControlNumbersDAL)->DecrementControlNumber('CustomerId',1);
                       return response()->json(['message'=>'Customer '.$request->ItemName.' existed already!'],404);
                   } 
               }
               $customer->update($request->all()); 
               return response()->json(['message2'=> 'Successfully Updated!', 'data' => $customer],200);
           }
           else{
             if ((new CustomersDAL)->IsDuplicate('CustomerId', $request->CustomerId)){
                 (new ControlNumbersDAL)->DecrementControlNumbers('CustomerId',1);
                 return response()->json(['message'=>'Customer '.$request->CustomerId.' existed already!'],404);
             } 
             if ((new CustomersDAL)->IsDuplicate('CustomerName', $request->CustomerName)){
                 (new ControlNumbersDAL)->DecrementControlNumbers('CustomerId',1);
                 return response()->json(['message'=>'Customer '.$request->CustomerName.' existed already!'],404);
             } 
             (new CustomersDAL)->SaveCustomers($request->all()); 
             return response()->json(['message'=> 'Successfully Save!'],200);
         }
     
         }
    // public function SaveEditCustomers(Request $request)
    // {
    //     // $request['CustomerId'] = 'CT1012';
    //     // $request['CustomerName'] = 'peds';
    //     // $request['Address'] = 'CORDOVA';
    //     // $request['ContactNo'] = '09099909';
        
    //    $customer = (new CustomersDAL)->GetCustomersId($request->CustomerId);

    //     if($customer)
    //     {
    //         $customer->update($request->all());
    //         return response()->json(['message'=>'updated'],200);
    //     }
    //     else
    //     {
    //         (new CustomersDAL)->SaveCustomers($request->all());
    //         return response()->json(['message'=>'saved!'],200);
            
    //     }

    // }
    public function DeleteCustomer($customerId)
    {
        $customer = (new CustomersDAL)->GetCustomersId($customerId);
        if($customer){
            $customer->delete();
            return response()->json(['message' => 'Customer deleted successfully'],200);
        }
        else{
            return response()->json(['error' => 'Customer not found'], 404);
        }
    }
}
