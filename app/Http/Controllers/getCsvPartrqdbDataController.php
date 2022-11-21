<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\partrqdbCsv;


class getCsvPartrqdbDataController extends Controller
{
    public function getCsvPartrqdbData($pn12digit){
        
        $data = partrqdbCsv::where('PN', '=', $pn12digit)->get(['MODEL'])->toArray();
//        $data = json_decode($data);
        return $data;
    }

    public static function getCsvPartrqdbDataLastUpdate(){
        
        if ( partrqdbCsv::take(1)->exists() ) {

            $data = partrqdbCsv::take(1)->get();
            $csvUpdated = $data[0]['csvUpdated'];
            return $csvUpdated;
        }else{
            return '';
        }
    }
    
            
}
