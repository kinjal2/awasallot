<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $table = 'public.applications';
protected $fillable = [
        'sono',
        'appln_name',
        'quarter_type',
        'batch_id',
    ];
}