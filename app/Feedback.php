<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    //
    protected $table='master.feedback';
    protected $fillable = [
        'name',
        'email',
        'contact_no',
        'message',
    ];
}
