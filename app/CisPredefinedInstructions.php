<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CisPredefinedInstructions extends Model
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
    protected $table = 'cis_predefined_instructions';
}
