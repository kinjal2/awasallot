<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tquarterrequesthistoryb extends Model
{
    use HasFactory;
    protected $table ='master.t_quarter_request_b_history';
    protected $fillable = [
        'requestid',
        'random_no',
        'quartertype',
        'uid',
        'old_qaid',
        'old_qaid_up_allotment',
        'prv_quarter_type',
        'prv_area',
        'prv_blockno',
        'prv_unitno',
        'prv_details',
        'prv_possession_date',
        'hc_quarter_type',
        'hc_area',
        'hc_blockno',
        'hc_unitno',
        'hc_details',
        'remarks',
        'request_date',
        'officecode',
        'inward_no',
        'is_accepted',
        'inward_date',
        'is_allotted',
        'qaid',
        'updatedby',
        'updatedon',
        'wno',
        'is_varified',
        'is_priority',
        'rivision_id',
        'reference_id',
        'reg_inward_no',
        'remarks_date',
        'is_hc',
        'updated_at',
        'created_at',
        'r_wno',
        'office_remarks',
        'is_withdraw',
        'withdraw_remarks',
        'is_ddo_varified',
        'choice1',
        'choice2',
        'choice3',
        'ddo_remarks',
        'ddo_code',
        'cardex_no',
        'created_by',
        'updated_by',
    ];
    
}
