<?php

namespace App;

use Illuminate\Database\Eloquent\Model;



class daicoCsv extends Model
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
    protected $table = 'daico_csv';
    

    
}
