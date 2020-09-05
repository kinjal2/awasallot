<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Loginn extends Model
{
    //
    protected $fillable = [
        'email_id','uid','password'
    ];
    public static function insertData($data){
       
        
        DB::table('userschema.login')->insert($data);
        
   
    }
}
