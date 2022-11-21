<?php

namespace App;

use Illuminate\Database\Eloquent\Model;



class partrqdbCsv extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
    
    protected $primaryKey = null;
    public $incrementing = false;
    
    /**
     *definování názvu tabulky
     * 
     * @var type 
     */
    protected $table = 'partrqdb_csv';
    

    
}
