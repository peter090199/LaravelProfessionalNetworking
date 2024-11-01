<?php

namespace App\Http\Controllers\FilesData;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customers;

class CustomersDAL extends Controller
{
    public function GetCustomers(){
        return Customers::all();
    }
    public function GetCustomerByCustomerId($customerId){
        return Customers::where('CustomerId',$customerId)->first();
    }

    public function SaveCustomers($data){
        return Customers::create($data);  
    }
    public function IsDuplicate($Column, $Value){
        $count = Customers::where($Column,$Value)
                        ->count();
        if($count > 0)
        {
            return true;
        }else{
            return false;
        }
    }
    public function GetCBOCustomers(){
        return Customers::where('RecordStatus','active')->get();
    }
}
