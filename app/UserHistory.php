<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserHistory extends Model
{
     // Specify full schema-qualified table name
    
     protected $table = 'userschema.users_history';

   protected $fillable = [
        'id',
        'name',
        'email',
        'email_verified_at',
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
        'sign',
        'current_address',
        'office_phone',
        'office_address',
        'is_activated',
        'is_profilechange',
        'image_contents',
        'last_login',
        'last_ip',
        'created_at',
        'updated_at',
        'is_admin',
        'otp',
        'otp_created_at',
        'status',
        'is_verified',
        'office_email_id',
        'is_police_staff',
        'is_fix_pay_staff',
        'police_staff_verify',
        'remarks',
        'phone_verified_at',
        'is_phy_dis',
        'dis_per',
        'is_judge',
        'ddo_code',
        'cardex_no',
        'pay_level',
        'dcode',
        'tcode',
        'from_old_awasallot_app',
        'updated_to_new_awasallot_app',
    ];
}


