<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Remarks extends Model
{
    //
    protected $table = 'master.m_remarks';
    protected $primaryKey = 'remark_id';
    protected $fillable = ['remark_id', 'description', 'rtype', 'updated_at', 'created_at'];

   

}
