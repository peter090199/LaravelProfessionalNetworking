<?php

namespace App\Http\Controllers\FilesUI;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\FilesData\ItemsDAL;
use App\Http\Controllers\ConfigData\ControlNumbersDAL;
use App\Models\Items;

class ItemsUI extends Controller
{
    // public function SaveEditItems(Request $request)
    // {
    //     // $request['ItemId'] = 'ITM0105';
    //     // $request['ItemName'] = 'TUMBLER';
    //     // $request['Available'] = 100;
    //     // $request['Price'] = 50;
    //     // $request['Cost'] = 100;
    //     // $request['UM'] = 'UM';
    //     // $request['Category'] = 'CHOCO';
        
    //     $item = (new ItemsDAL)->GetItemsByItemId($request->ItemId);

    //     if($item){
    //         $item->update($request->all());
    //         return response()->json(['message'=>'updated'],200);
    //     }
    //     else{
    //         (new ItemsDAL)->SaveData($request->all());
    //         return response()->json(['message'=>'saved!'],200);
    //       //return 123;
    //     }
    // }
public function SaveEditItems(Request $request){
   $item  =  (new ItemsDAL)->GetItemsByItemId($request['ItemId']); 
      if ($request['ItemId']  == 'generated') {
          do
          {
              $request['ItemId']  =  (new ControlNumbersDAL)->GenerateId('ItemId','PItemId');
              (new ControlNumbersDAL)->IncrementControlNumber('ItemId');
              $record = (new ItemsDAL)->GetItemsByItemId($request['ItemId']);
          } while ($record != null);
      }

      if($item){
          if ($item->ItemId != $request->ItemId){
              if ((new ItemsDAL)->IsDuplicate('ItemId', $request->ItemId)){
                  (new ControlNumbersDAL)->DecrementControlNumber('ItemId',1);
                  return response()->json(['message'=>'Item '.$request->ItemId.' existed already!'],404);
              } 
          }
          if ($item->ItemName != $request->ItemName){
              if ((new ItemsDAL)->IsDuplicate('ItemName', $request->ItemName)){
                  (new ControlNumbersDAL)->DecrementControlNumber('ItemId',1);
                  return response()->json(['message'=>'Item '.$request->ItemName.' existed already!'],404);
              } 
          }
          $item->update($request->all()); 
          return response()->json(['message2'=> 'Successfully Updated!', 'data' => $item],200);
      }
      else{
        if ((new ItemsDAL)->IsDuplicate('ItemId', $request->ItemId)){
            (new ControlNumbersDAL)->DecrementControlNumbers('ItemId',1);
            return response()->json(['message'=>'Item '.$request->ItemId.' existed already!'],404);
        } 
        if ((new ItemsDAL)->IsDuplicate('ItemName', $request->ItemName)){
            (new ControlNumbersDAL)->DecrementControlNumbers('ItemId',1);
            return response()->json(['message'=>'Item '.$request->ItemName.' existed already!'],404);
        } 
        (new ItemsDAL)->SaveData($request->all()); 
        return response()->json(['message2'=> 'Successfully Save!'],200);
    }

    }

    public function DeleteItem($itemId)
    {
        $item = (new ItemsDAL)->GetItemsByItemId($itemId);
        if($item){
            $item->delete();
            return response()->json(['message' => 'Employee deleted successfully'],200);
        }
        else{
            return response()->json(['error' => 'Employee not found'], 404);
        }
    }
    public function Calculation()
    {
        $num1 = 5;
        $num2 = 5;

        $sum = $num1 + $num2;
        $diff = $num1 - $num2;
        $pro = $num1 * $num2;
        $quo = $num1 / $num2;
        $rem = $num1 % $num2;

        return response()->json(['sum'=> $sum,'diff'=> $diff,'pro'=> $pro,'quo'=> $quo,'rem'=> $rem], 200);
    }
    public function ForeachLoop()
    {
        $items = (new ItemsDAL)->GetItems();
        $data =[];
        foreach($items as $item)
        {
            $TotalStockCost = $item->Available * $item->Cost;
            $data[]= $item->ItemName. '@' .$item->Price. '='.$TotalStockCost;
        }
        return response()->json(['message' => $data],200);
    }

    public function DoWhileLoop(){
      $i = 0;
      $data = "";
      do{
        $data .= $i.',';
        $i++;
      }while($i != 10);
      return response()->json(['message' => $data],200);
    }

    public function DoWhileLoops(){
        $i = 0;
        $data = "";
        do{
          $data .= $i.',';
          $i = $i + 2;
        }while($i != 10);
        return response()->json(['message' => $data],200);
      }
  
    
      
    
    // public function Delete($id){

    //     // Find the employee record by ID
    //     $item = Items::find($id);
 
    //     // Check if the employee record exists
    //     if (!$item) {
    //         return response()->json(['error' => 'Employee not found'], 404);
    //     }
    //     // Delete the employee record
    //     $item->delete();
    //     return response()->json(['message' => 'Employee deleted successfully']);
    //  }
}
