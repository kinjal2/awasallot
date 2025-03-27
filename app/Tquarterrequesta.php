<?php

namespace App;
use App\Traits\MaxRwnoTrait;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class Tquarterrequesta extends Model
{
    //
    use MaxRwnoTrait;
    protected $table ='master.t_quarter_request_a';

    protected $primaryKey = ['quartertype', 'requestid','uid','rivision_id'];
    protected $fillable = ['requestid', 'wno', 'wno_flag', 'random_no', 'quartertype', 'uid', 'old_office', 'deputation_date', 'prv_area_name', 'prv_building_no', 'prv_quarter_type', 'prv_rent', 'prv_handover', 'prv_requestid', 'have_old_quarter', 'old_quarter_details', 'is_scst', 'scst_info', 'is_relative', 'relative_details', 'is_relative_householder', 'relative_house_details', 'have_house_nearby', 'nearby_house_details', 'downgrade_allotment', 'remarks', 'request_date', 'officecode', 'inward_no', 'is_accepted', 'inward_date', 'is_allotted', 'qaid', 'updatedby', 'updatedon','old_designation', 'is_varified', 'is_priority','dgrid', 'rivision_id', 'reference_id', 'reg_inward_no', 'remarks_date', 'is_downgrade_request', 'dg_rivision_id', 'updated_at', 'created_at', 'r_wno', 'office_remarks', 'is_withdraw', 'withdraw_remarks','is_ddo_varified','choice1','choice2','choice3','ddo_remarks','cardex_no','ddo_code'];
    public $incrementing = false;

    public function usermaster()
    {
        return $this->belongsTo(User::class, 'uid', 'id'); // Define the inverse relationship
    }
    public function getFormattedRequestData($requestid, $rivision_id)
    {
        $request = $this->with(['usermaster' => function ($query) {
            $query->select([
                'id', 'name', 'email', 'email_verified_at', 'password',
                'remember_token', 'usercode', 'office_eng', 'designationcode',
                'designation', 'office', 'is_dept_head', 'is_transferable',
                'appointment_date', 'salary_slab', 'grade_pay', 'basic_pay',
                'personal_salary', 'special_salary', 'actual_salary', 'deputation_allowance',
                'address', 'maratial_status', 'contact_no', 'pancard',
                'gpfnumber', 'date_of_retirement', 'date_of_transfer', 'date_of_birth',
                'image', 'sign', 'current_address', 'office_phone',
                'office_address', 'is_activated', 'is_profilechange', 'image_contents',
                'last_login', 'last_ip', 'created_at', 'updated_at', 'is_admin',
                'otp', 'otp_created_at', 'status', 'is_verified', 'office_email_id',
                'is_police_staff', 'is_fix_pay_staff', 'police_staff_verify', 'remarks'
            ]);
        }])
        ->select([
            'wno', 'quartertype', 'uid', 'old_office', 'old_designation', 'deputation_date', 'prv_area_name', 'prv_building_no',
            'prv_quarter_type', 'prv_rent', 'prv_handover',
            'have_old_quarter', 'old_quarter_details',
            'is_scst', 'scst_info',
            'is_relative', 'relative_details',
            'is_relative_householder', 'relative_house_details',
            'have_house_nearby', 'nearby_house_details',
            'downgrade_allotment', 'request_date', 'inward_no', 'inward_date', 'is_varified','requestid','rivision_id','dgrid','is_ddo_varified','uid','choice1','choice2','choice3','ddo_remarks'
        ])
        ->where('requestid', $requestid)
        ->where('rivision_id', $rivision_id)
        ->first();

        if (!$request) {
            return null; // or handle not found case as needed
        }

        return [
            'uid' => $request->usermaster->id,
            'quartertype' => $request->quartertype,
            'rivision_id'=> $request->rivision_id,
            'requestid'=> $request->requestid,
            'prv_area_name' => $request->prv_area_name,
            'prv_building_no'  => $request->prv_building_no,
            'prv_quarter_type' => $request->prv_quarter_type,
            'prv_rent' => $request->prv_quarter_type,
            'have_old_quarter'=> $request->have_old_quarter,
            'prv_handover'=> $request->prv_handover,
            'old_quarter_details'=> $request->old_quarter_details,
            'is_relative'=> $request->is_relative,
            'relative_details'=> $request->relative_details,
            'is_relative_householder'=> $request->is_relative_householder,
            'have_house_nearby'=> $request->have_house_nearby,
            'nearby_house_details'=> $request->nearby_house_details,
            'downgrade_allotment'=> $request->downgrade_allotment,
            'relative_house_details'=> $request->relative_house_details,
            'name' => $request->usermaster->name,
            'designation' => $request->usermaster->designation,
            'is_dept_head' => $request->usermaster->is_dept_head,
            'officename' => $request->usermaster->office,
            'officeaddress' => $request->usermaster->office_address,
            'old_desg' => $request->old_designation, // Note: use the correct field name
            'old_office' => $request->old_office,
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
            'is_ddo_varified' => $request->is_ddo_varified,
            'user_id'=>$request->uid,
            'chioce1'=>$request->chioce1,
            'choice2'=>$request->choice2,
            'choice3'=>$request->choice3,
            'ddo_remarks'=>$request->ddo_remarks
        ];
    }
}
