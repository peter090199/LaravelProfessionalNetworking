<?php

namespace App\Http\Controllers\ConfigData;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ControlNumbers;

class ControlNumbersDAL extends Controller
{
    public function GenerateId($Column, $PColumn){
        $data = ControlNumbers::first();
        return $data->$PColumn.$data->$Column;
    }

    public function IncrementControlNumber($Column){
        $record =  ControlNumbers::first();
        if ($record) {
            $updatedValue = $record->{$Column} + 1;
            $record->update([
                $Column => $updatedValue
            ]);
        }
    }

    public function DecrementControlNumbers($Column){
        $record =  ControlNumbers::first();
        if ($record) {
            $updatedValue = $record->{$Column} - 1;
            $record->update([
                $Column => $updatedValue
            ]);
        }
    }

}
