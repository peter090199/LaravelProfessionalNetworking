<?php

namespace App\Http\Controllers\FilesData;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Items;

class ItemsDAL extends Controller
{
    public function GetItems(){
        return Items::all();
    } 
    public function GetItemsByItemId($itemId){
        return Items::where('ItemId',$itemId)->first();
    }
    
    public function SaveData($data){
        return Items::create($data);  
    }
    
    public function IsDuplicate($Column, $Value){
        $count = Items::where($Column,$Value)
                        ->count();
        if($count > 0)
        {
            return true;
        }else{
            return false;
        }
    }
    public function GetItemsToSale()
    {
        return Items::select('ItemId','ItemName','Available','UM','Category','Price')->where('RecordStatus','active')->get();
    }
    
    public function GetItemsToSales()
    {
        return Items::select("
            SELECT ItemId, ItemName, Available, UM, Category, Price
            FROM items
            WHERE RecordStatus = 'active'
        ");
    }
    

}
