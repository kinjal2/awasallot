<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DrawLog extends Model
{
    
     protected $table = 'log.draw_log';

    protected $primaryKey = 'id';

    public $timestamps = false; // because table uses createdon instead

    protected $fillable = [
        'uid',
        'batch_id',
        'operation',
        'remarks',
        'ip',
        'createdon'
    ];

    protected $casts = [
        'createdon' => 'datetime'
    ];
}
