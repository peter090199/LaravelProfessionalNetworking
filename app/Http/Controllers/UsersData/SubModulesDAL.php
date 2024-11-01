<?php

namespace App\Http\Controllers\UsersData;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubModules;

class SubModulesDAL extends Controller
{
    public function GetSubModules(){
        return SubModules::select('id','SubModule','ModuleId','Route')
        ->where('RecordStatus','active')
        ->get();
    }
}
