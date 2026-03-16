<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DrawBatch extends Model
{
    protected $table = 'public.draw_batches';

    protected $fillable = [
       'batch_title',
    'quarter_type',
    'draw_status',
    'demo_run_count',
    'batch_no',
    'draw_date',
    'satisfy_with_final'
    ];

    protected $casts = [
    'satisfy_with_final' => 'boolean',
];
}