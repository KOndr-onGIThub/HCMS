<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use App\MyUtilities\DateUtils;


class Hotcall extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
    
    /**
     *definování názvu tabulky
     * 
     * @var type 
     */
    protected $table = 'hotcall';
    
    
    /**
     * 
     * @return type
     */
    public function mujCas($time)
        {
        $cas = DateUtils::formatTime($time);
        return($cas);
        }
    /**
     * 
     * @param type $date
     * @return type
     */
    public function mujDatum($date)
        {
        $datum = DateUtils::formatDate($date);
        return($datum);
        }
    
}
