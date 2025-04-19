<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tquarterequesthistorya extends Model
{
    use HasFactory;
    protected $table ='master.t_quarter_request_a_history';
    protected $fillable = [
        'requestid',
        'wno',
        'random_no',
        'quartertype',
        'uid',
        'old_office',
        'deputation_date',
        'prv_area_name',
        'prv_building_no',
        'prv_quarter_type',
        'prv_rent',
        'prv_handover',
        'prv_requestid',
        'have_old_quarter',
        'old_quarter_details',
        'is_scst',
        'scst_info',
        'is_relative',
        'relative_details',
        'is_relative_householder',
        'relative_house_details',
        'have_house_nearby',
        'nearby_house_details',
        'downgrade_allotment',
        'remarks',
        'request_date',
        'officecode',
        'inward_no',
        'is_accepted',
        'inward_date',
        'is_allotted',
        'old_designation',
        'is_varified',
        'is_priority',
        'dgrid',
        'rivision_id',
        'reference_id',
        'qaid',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
    ];
    

}
