<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;
use App\daicoCsv;
use App\Http\Controllers\getCsvDaicoDataController;
use League\Csv\Reader;
//use League\Csv\Statement;
use Illuminate\Support\Str;
use App\MyUtilities\DateUtils;
use Illuminate\Support\Facades\Log;


class daicoCsvController extends Controller
{
    
    public function store()
    {
        
        $pathAndFile = public_path('files\Daico.csv');
        
        // zjistim posledni update souboru
        $csvUpdated = DateUtils::formatDateTime( filemtime($pathAndFile)) ;
        $timeStampInDB = getCsvDaicoDataController::getCsvDaicoDataLastUpdate();
        
        //porovnam to z hodnotou v DB zavolanim metody z kontroleru pro ziskani dat z csv daico
        if($csvUpdated === $timeStampInDB){
            // pokud jsou data stejna, tak jen zapisu pokus do logu
            Log::notice('MyLog "daicoCsvController" **Data v DB tabulce "daico_csv" a v csv souboru ve slozce "public" jsou stejne stara (jsou z ' . $csvUpdated . ' cas je zrejme v UTC pasmu). DB tabulka proto nebyla aktualizovana.**');
//            return 'false';
        }else{
            // clear DB table
            daicoCsv::truncate(); 
            
        //load the CSV document from a file path
        $csv = Reader::createFromPath($pathAndFile, 'r');
        $csv->setHeaderOffset(0);
        $csv->setDelimiter(','); // carka je vychozi oddelovac, ale ...
            
            //provedu validaci a ulozeni dat do DB a na konci to zapisu do logu
                $i=1; //first row
            foreach($csv as $record){

                $daicoToDB = new daicoCsv(); // new instance

                    $daicoToDB->idrow = $i++; // number of row

                    if ( Str::length($record['KPA_KEY'])<=14 ){
                        $daicoToDB->KPA_KEY = $record['KPA_KEY'];
                    } else {
                        $daicoToDB->KPA_KEY = 'valid error';
                    }
                    if ( Str::length($record['IKA_KEY'])<=14 ){
                        $daicoToDB->IKA_KEY = $record['IKA_KEY'];
                    } else {
                        $daicoToDB->IKA_KEY = 'valid error';
                    }
                    if ( is_numeric($record['BOX_MIN']) && Str::length($record['BOX_MIN'])<=9 ){
                        $daicoToDB->BOX_MIN = $record['BOX_MIN'];
                    } else {
                        $daicoToDB->BOX_MIN = '';
                    }
                    if ( is_numeric($record['REQUESTED_CAPA']) && $record['REQUESTED_CAPA']>=0 && $record['REQUESTED_CAPA']<=32767 ){
                        $daicoToDB->REQUESTED_CAPA = $record['REQUESTED_CAPA'];
                    } else {
                        $daicoToDB->REQUESTED_CAPA = '';
                    }
                    if ( is_numeric($record['REAL_CAPA']) && $record['REAL_CAPA']>=0 && $record['REAL_CAPA']<=32767 ){
                        $daicoToDB->REAL_CAPA = $record['REAL_CAPA'];
                    } else {
                        $daicoToDB->REAL_CAPA = '';
                    }
                    if ( is_numeric($record['SAFETY_BOX']) && $record['SAFETY_BOX']>=0 && $record['SAFETY_BOX']<=32767 ){
                        $daicoToDB->SAFETY_BOX = $record['SAFETY_BOX'];
                    } else {
                        $daicoToDB->SAFETY_BOX = '';
                    }
                    if ( is_numeric($record['HC_LEVEL']) && $record['HC_LEVEL']>=0 && $record['HC_LEVEL']<=32767 ){
                        $daicoToDB->HC_LEVEL = $record['HC_LEVEL'];
                    } else {
                        $daicoToDB->HC_LEVEL = '';
                    }
                    if ( Str::length($record['PICKER'])<=2 ){
                        $daicoToDB->PICKER = $record['PICKER'];
                    } else {
                        $daicoToDB->PICKER = '';
                    }
                    if ( is_numeric($record['SAFETY_PC_STORE']) && $record['SAFETY_PC_STORE']>=0 && $record['SAFETY_PC_STORE']<=32767 ){
                        $daicoToDB->SAFETY_PC_STORE = $record['SAFETY_PC_STORE'];
                    } else {
                        $daicoToDB->SAFETY_PC_STORE = '';
                    }
                    if (is_numeric($record['REQ_PC_CAPA']) && $record['REQ_PC_CAPA']<99999999999999 ) {
                        $daicoToDB->REQ_PC_CAPA = $record['REQ_PC_CAPA'];
                     } else {
                        $daicoToDB->REQ_PC_CAPA = '';
                     }
                    if (is_numeric($record['REAL_PC_CAPA']) && $record['REAL_PC_CAPA']<99999999999999 ) {
                        $daicoToDB->REAL_PC_CAPA = $record['REAL_PC_CAPA'];
                     } else {
                        $daicoToDB->REAL_PC_CAPA = '';
                     }

                     $daicoToDB->csvUpdated = $csvUpdated;

                $daicoToDB->save();
            }
        Log::notice('MyLog "daicoCsvController" **Data v DB tabulce "daico_csv" byla aktualizovana z '.$pathAndFile.' (nový soubor je z  '. $csvUpdated .' první záznam v DB měl datum '. $timeStampInDB .' cas je zrejme v UTC pasmu).**');
//        return 'true';
        }

//        return redirect('/Hotcall');
//        return view('daico.index',compact('dataFromDaicoCsv', 'header', 'records', 'daicoArray'));

    }
    
    
    

    
    



    
}
