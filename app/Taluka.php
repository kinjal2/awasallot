<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Taluka extends Model
{
    use HasFactory;

     // Define the table name
     protected $table = 'master.taluka';

     // Define the primary key
    protected $primaryKey = 'tcode';

     // Specify the fillable fields
     protected $fillable = [
        'tcode',
        'id',
        'name_g',
        'name_e',
        'dcode',
        'prant_id',
        'is_active',
    ];

}
