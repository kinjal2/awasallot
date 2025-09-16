<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    protected $table='master.visitors';
    protected $fillable = ['count'];
}
