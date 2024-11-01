<?php

namespace App\Http\Controllers\UsersData;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Modules;

class ModulesDAL extends Controller
{
    public function GetModules(){

        return Modules::select('id','Module')
        ->where('RecordStatus','active')
        ->get();
    }
}
