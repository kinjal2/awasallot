<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DdoList extends Model
{
    use HasFactory;
    protected $table = 'master.ddo_list';
    protected $primaryKey = 'id';
    protected $fillable = ['id','ddo_office_name', 'district_name', 'cardex_no', 'ddo_registration_no', 'dto_registration_no', 'email', 'mobile_no', 'created_at', 'updated_at'];

}
