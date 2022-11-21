<?php

namespace App\Http\Controllers;

use App\partrqdbCsv;
use App\Http\Controllers\getCsvPartrqdbDataController;
use League\Csv\Reader;
use Illuminate\Support\Str;
use App\MyUtilities\DateUtils;
use Illuminate\Support\Facades\Log;


class partrqdbCsvController extends Controller
{
    protected $csv;
    protected $pathAndFile;
    protected $csvUpdated;
    protected $pn;
    protected $family;
    protected $suffix;
    protected $ordercode;
    
    
    public function store()
    {
        
        $pathAndFile = public_path('files/PARTRQDB.CSV');
        
        // zjistim posledni update souboru
        $csvUpdated = DateUtils::formatDateTime( filemtime($pathAndFile)) ;
        //porovnam to z hodnotou v DB zavolanim metody z kontroleru pro ziskani dat z csv daico
        if($csvUpdated == getCsvPartrqdbDataController::getCsvPartrqdbDataLastUpdate()){

            // pokud jsou data stejna, tak jen zapisu pokus do logu
            Log::notice('MyLog "partrqdbCsvController" **Data v DB tabulce "partrqdb_csv" a v csv souboru ve slozce "public" jsou stejne stara (jsou z ' . $csvUpdated . ' cas je zrejme v UTC pasmu). DB tabulka proto nebyla aktualizovana.**');
            return 'falseXY';
        }else{
            
            

        //load the CSV document from a file path
        $csv = Reader::createFromPath($pathAndFile, 'r');
        $csv->setHeaderOffset(0);
        $csv->setDelimiter(';'); // carka je vychozi oddelovac, ja chci strednik
        
            //jinak provedu validaci a ulozeni dat do DB a na konci to zapisu do logu

            // clear table
            partrqdbCsv::truncate(); 

                $i=1; //first row
            foreach($csv as $record){

                $partrqdbToDB = new partrqdbCsv(); // new instance

                $partrqdbToDB->idrow = $i++; // number of row

                $ordercode = $record['ORDERCODE'];
                $suffix = $record['SUFFIX'];
                $suffix = strlen($suffix) == 1 ? '00' : $suffix;
                $family = $record['FAMILY'];
                $itemNew = $ordercode . $suffix . $family;
                $pn = $ordercode . $suffix;


                if( partrqdbCsv::where('PN_AND_MODEL', '=', $itemNew)->exists() ){
                    //pokud uz tam ten zaznam je tak ho neulozim
                }else{
                    // jinak ho ulozim
                    $partrqdbToDB->PN_AND_MODEL = $itemNew;
                    $partrqdbToDB->PN = $pn;
                    $partrqdbToDB->MODEL = $family;
                    $partrqdbToDB->csvUpdated = $csvUpdated;
                    $partrqdbToDB->save();
                }
            }
        Log::notice('MyLog "partrqdbCsvController" **Data v DB tabulce "partrqdb_csv" byla aktualizovana z csv souboru ve slozce "public" (data jsou z ' . $csvUpdated . ' cas je zrejme v UTC pasmu).**');
        return 'trueXX';
        
        }            
    }
    
    
}
