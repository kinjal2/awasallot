<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tquarterrequestc extends Model
{
    //
    protected $table ='master.t_quarter_request_c';
    protected $primaryKey='requestid';
    protected $casts = [
        'wno' => 'integer',
    ];
    protected $fillable=['choice1','choice2','choice3','ddo_remarks','cardex_no','ddo_code'];
}
