<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FilesData\ItemsDAL;
use App\Http\Controllers\FilesUI\ItemsUI;
use App\Http\Controllers\FilesData\CustomersDAL;
use App\Http\Controllers\FilesUI\CustomersUI;
use App\Http\Controllers\UsersData\ModulesDAL;
use App\Http\Controllers\UsersData\SubModulesDAL;
use App\Http\Controllers\FilesData\SuppliersDAL;
use App\Http\Controllers\FilesUI\SuppliersUI;
use App\Http\Controllers\SalesData\SalesTransactionDAL;
use App\Http\Controllers\SalesData\SalesHeadersDAL;
use App\Http\Controllers\SalesData\SalesDetailsDAL;
use App\Http\Controllers\SalesUI\SaleTransactionUI;
use App\Http\Controllers\SalesUI\SalesReceiptUI;
use App\Http\Controllers\SalesUI\EditSaleRecordUI;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;

Route::controller(LoginController::class)->group(function(){
   Route::post('/login','login'); 
});
Route::controller(RegisterController::class)->group(function(){
   Route::post('/signup','signup'); 
});
Route::controller(RegisterController::class)->group(function(){
   Route::get('/getEmailByName','getEmailByName'); 
});

Route::controller(ItemsDAL::class)->group(function(){
   Route::get('/GetItems','GetItems'); 
   Route::get('/GetItemsByItemId/{ItemId}','GetItemsByItemId'); 
});

Route::controller(ItemsUI::class)->group(function(){
    Route::post('/SaveEditItems','SaveEditItems'); 

    Route::post('/Calculation','Calculation'); 
    Route::get('/ForeachLoop','ForeachLoop'); 
    Route::get('/DoWhileLoop','DoWhileLoop');
    Route::get('/DoWhileLoops','DoWhileLoops');
    Route::get('/DeleteItem/{ItemId}', 'DeleteItem');
 });

 Route::controller(CustomersDAL::class)->group(function(){
   Route::get('/GetCustomers','GetCustomers'); 
   Route::get('/GetCustomerByCustomerId/{id}','GetCustomerByCustomerId'); 
});

Route::controller(CustomersUI::class)->group(function(){
   Route::post('/SaveEditCustomers','SaveEditCustomers'); 
   Route::delete('/DeleteCustomer/{CustomerId}', 'DeleteCustomer');
  
});

Route::controller(ModulesDAL::class)->group(function(){
   Route::get('/GetModules','GetModules'); 
});

Route::controller(SubModulesDAL::class)->group(function(){
   Route::get('/GetSubModules','GetSubModules'); 
});

//Supplier
Route::controller(SuppliersDAL::class)->group(function(){
   Route::get('/GetSuppliers','GetSuppliers'); 
});

Route::controller(SuppliersUI::class)->group(function(){
   Route::post('/SaveEditSuppliers','SaveEditSuppliers'); 
 //  Route::delete('/DeleteSupplier/{SupplierId}', 'DeleteSupplier');
   Route::delete('/DeleteSupplier/{SupplierId}', 'DeleteSupplier');
  
});

Route::controller(SalesTransactionDAL::class)->group(function(){
   Route::get('/GetTransSaleNo','GetTransSaleNo'); 
});

Route::controller(SalesHeadersDAL::class)->group(function(){
   Route::get('/GetSaleHeaderByTransNo/{transNo}','GetSaleHeaderByTransNo'); 
   Route::get('/GetSaleHeaderByTransDateFromByTransDateTo/{TransDateFrom}/{TransDateTo}','GetSaleHeaderByTransDateFromByTransDateTo');
 //  Route::get('/UpdateSaleHeaderStatusByReceiptNo/{ReceiptNo}/{RecordStatus}', 'UpdateSaleHeaderStatusByReceiptNo');

});

Route::controller(SalesDetailsDAL::class)->group(function(){
   Route::get('/GetSaleDetailsByTransNo/{transNo}','GetSaleDetailsByTransNo'); 
   Route::delete('/DeleteSaleDetailById{Id}','DeleteSaleDetailById');
   Route::get('/GetSaleDetailsByReceiptNoByRecordStatus/{ReceiptNo}/{RecordStatus}','GetSaleDetailsByReceiptNoByRecordStatus'); 

});


Route::controller(CustomersDAL::class)->group(function(){
   Route::get('/GetCBOCustomers','GetCBOCustomers'); 
});
Route::controller(ItemsDAL::class)->group(function(){
   Route::get('/GetItemsToSale','GetItemsToSale'); 
});


Route::controller(SaleTransactionUI::class)->group(function(){
   Route::get('/SaveToSaleHeaders/{ItemId}/{TransNo}/{CustomerId}', 'SaveToSaleHeaders');
   Route::get('/UpdateElementSaleDetail/{Id}/{Column}/{Value}', 'UpdateElementSaleDetail');
   Route::post('/UpdateSaleDetail', 'UpdateSaleDetail');
   Route::post('/UpdateSaleHeader/{ForAction}','UpdateSaleHeader');
});

Route::controller(SalesReceiptUI::class)->group(function(){
   Route::get('/UpdateSaleHeaderStatusByReceiptNo/{ReceiptNo}/{RecordStatus}', 'UpdateSaleHeaderStatusByReceiptNo');
});

Route::controller(EditSaleRecordUI::class)->group(function (){
   Route::get('/GetSaleDetailsByTransDateFromByTransDateTo/{DateFrom}/{DateTo}', 'GetSaleDetailsByTransDateFromByTransDateTo');
});










 


 


