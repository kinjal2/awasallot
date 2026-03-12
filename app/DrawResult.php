<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DrawResult extends Model
{
   protected $table = 'public.draw_results';
protected $fillable = [
    'premise_no',
    'appln_name',
    'draw_date',
    'quarter_type',
    'batch_id',
    'draw_type',   // demo / final
    'run_no'       // demo run number
];
}
