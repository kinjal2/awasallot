<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Premise extends Model
{
     protected $table = 'public.premises';
    protected $fillable = [
        'srno',
        'premise_no',
        'quarter_type',
        'batch_id',

    ];
}