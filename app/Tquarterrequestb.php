<?php

namespace App;

use App\Traits\MaxRwnoTrait;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Tquarterrequestb extends Model
{
    //
    use MaxRwnoTrait;
    protected $table = 'master.t_quarter_request_b';
    protected $primaryKey = 'requestid';
    //protected $fillable = ['requestid', 'wno', 'wno_flag', 'random_no', 'quartertype', 'uid', 'old_office', 'deputation_date', 'prv_area_name', 'prv_building_no', 'prv_quarter_type', 'prv_rent', 'prv_handover', 'prv_requestid', 'have_old_quarter', 'old_quarter_details', 'is_scst', 'scst_info', 'is_relative', 'relative_details', 'is_relative_householder', 'relative_house_details', 'have_house_nearby', 'nearby_house_details', 'downgrade_allotment', 'remarks', 'request_date', 'officecode', 'inward_no', 'is_accepted', 'inward_date', 'is_allotted', 'qaid', 'updatedby', 'updatedon','old_designation', 'is_varified', 'is_priority','dgrid', 'rivision_id', 'reference_id', 'reg_inward_no', 'remarks_date', 'is_downgrade_request', 'dg_rivision_id', 'updated_at', 'created_at', 'r_wno', 'office_remarks', 'is_withdraw', 'withdraw_remarks','choice1','choice2','choice3','ddo_remarks','cardex_no','ddo_code'
    //];
    protected $fillable = [
        'requestid',
        'wno',
        'wno_flag',
        'random_no',
        'quartertype',
        'uid',
        'old_office',
        'deputation_date',
        'prv_area_name',
        'prv_building_no',
        'prv_quarter_type',
        'prv_area',
        'prv_blockno',
        'prv_unitno',
        'prv_details',
        'prv_possession_date',
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
        'qaid',
        'updatedby',
        'updatedon',
        'old_designation',
        'is_varified',
        'is_priority',
        'dgrid',
        'rivision_id',
        'reference_id',
        'reg_inward_no',
        'remarks_date',
        'is_downgrade_request',
        'dg_rivision_id',
        'updated_at',
        'created_at',
        'r_wno',
        'office_remarks',
        'is_withdraw',
        'withdraw_remarks',
        'choice1',
        'choice2',
        'choice3',
        'ddo_remarks',
        'cardex_no',
        'ddo_code',
        'is_hc',
        'hc_quarter_type',
        'hc_area',
        'hc_blockno',
        'hc_unitno',
        'hc_details'
    ];
    public function usermaster()
    {
        return $this->belongsTo(User::class, 'uid', 'id');
    }
    public function getFormattedRequestData($requestid, $revision_id)
    {
        $request = TQuarterRequestb::with(['usermaster' => function ($query) {
            $query->select([
                'id',
                'name',
                'email',
                'email_verified_at',
                'password',
                'remember_token',
                'usercode',
                'office_eng',
                'designationcode',
                'designation',
                'office',
                'is_dept_head',
                'is_transferable',
                'appointment_date',
                'salary_slab',
                'grade_pay',
                'basic_pay',
                'personal_salary',
                'special_salary',
                'actual_salary',
                'deputation_allowance',
                'address',
                'maratial_status',
                'contact_no',
                'pancard',
                'gpfnumber',
                'date_of_retirement',
                'date_of_transfer',
                'date_of_birth',
                'image',
                'sign',
                'current_address',
                'office_phone',
                'office_address'
            ]);
        }])
            ->select([
                'wno',
                'quartertype',
                'uid',
                'request_date',
                'inward_no',
                'inward_date',
                'is_varified',
                'requestid',
                'rivision_id',
                'uid',
                'choice1',
                'choice2',
                'choice3',
                'ddo_remarks',
                'prv_area',
                
                'prv_quarter_type',
                
                'prv_blockno',
                'prv_unitno',
                'prv_details',
                'prv_possession_date',
               
               
               
                
                'is_hc',
                'hc_quarter_type',
                'hc_area',
                'hc_blockno',
                'hc_unitno',
                'hc_details',
                'random_no',
                'updatedby',
                'updatedon',
                'reg_inward_no',
                'remarks_date',
                'updated_at',
                'created_at',
                'r_wno',
                'office_remarks',
                'is_withdraw',
                'withdraw_remarks',
                'officecode',
                'cardex_no',
                'ddo_code',
                'is_accepted',
                'is_allotted',
                'qaid'

            ])
            ->where('requestid', $requestid)
            ->where('rivision_id', $revision_id)
            ->first(); // Fetch the first result

        // Check if the result is null
        if ($request) {
            return [
                'uid' => $request->usermaster->id,
                'quartertype' => $request->quartertype,
                'requestid' => $request->requestid,
                'rivision_id' => $request->rivision_id,
                'prv_area_name' => $request->prv_area_name,
                'prv_building_no' => $request->prv_building_no,
                'prv_blockno' => $request->prv_blockno,
                'prv_unitno' => $request->prv_unitno,
                'prv_details' => $request->prv_details,
                'prv_possession_date' => $request->prv_possession_date,
                'prv_quarter_type' => $request->prv_quarter_type,
                'hc_quarter_type' => $request->hc_quarter_type,
                'hc_area' => $request->hc_area,
                'hc_blockno' => $request->hc_blockno,
                'hc_unitno' => $request->hc_unitno,
                'hc_details' => $request->hc_details,
                'request_date' => $request->request_date,
                'prv_rent' => $request->prv_rent, // Corrected to use $request->prv_rent
                'have_old_quarter' => $request->have_old_quarter,
                'prv_handover' => $request->prv_handover,
                'old_quarter_details' => $request->old_quarter_details,
                'is_relative' => $request->is_relative,
                'relative_details' => $request->relative_details,
                'is_relative_householder' => $request->is_relative_householder,
                'have_house_nearby' => $request->have_house_nearby,
                'nearby_house_details' => $request->nearby_house_details,
                'downgrade_allotment' => $request->downgrade_allotment,
                'relative_house_details' => $request->relative_house_details,
                'name' => $request->usermaster->name,
                'designation' => $request->usermaster->designation,
                'is_dept_head' => $request->usermaster->is_dept_head,
                'officename' => $request->usermaster->office,
                'officeaddress' => $request->usermaster->office_address,
                'officephone' => $request->usermaster->office_phone,
                'deputation_date' => Carbon::parse($request->deputation_date)->format('d-m-Y'),
                'address' => $request->usermaster->address,
                'date_of_retirement' => Carbon::parse($request->usermaster->date_of_retirement)->format('d-m-Y'),
                'gpfnumber' => $request->usermaster->gpfnumber,
                'appointment_date' => Carbon::parse($request->usermaster->appointment_date)->format('d-m-Y'),
                'date_of_birth' => Carbon::parse($request->usermaster->date_of_birth)->format('d-m-Y'),
                'salary_slab' => $request->usermaster->salary_slab,
                'actual_salary' => $request->usermaster->actual_salary,
                'basic_pay' => $request->usermaster->basic_pay,
                'personal_salary' => $request->usermaster->personal_salary,
                'special_salary' => $request->usermaster->special_salary,
                'deputation_allowance' => $request->usermaster->deputation_allowance,
                'totalpay' => $request->usermaster->basic_pay + $request->usermaster->personal_salary + $request->usermaster->special_salary + $request->usermaster->deputation_allowance,
                'maratial_status' => $request->usermaster->maratial_status,
                'user_id' => $request->uid,
                'chioce1' => $request->chioce1,
                'choice2' => $request->choice2,
                'choice3' => $request->choice3,
                'ddo_remarks' => $request->ddo_remarks
            ];
        }

        return null; // or handle the case where no record was found
    }

    /*
}*/
}
