<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Carbon\Carbon;
use App\Notifications\CustomVerifyEmail;


class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    protected $table = 'userschema.users'; // Ensure this is the correct table
    protected $fillable = [
        'id', 'name', 'email', 'email_verified_at', 'password', 'remember_token',
        'usercode', 'office_eng', 'designationcode', 'designation', 'office', 
        'is_dept_head', 'is_transferable', 'appointment_date', 'salary_slab', 
        'grade_pay', 'basic_pay', 'personal_salary', 'special_salary', 
        'actual_salary', 'deputation_allowance', 'address', 'maratial_status', 
        'contact_no', 'pancard', 'gpfnumber', 'date_of_retirement', 
        'date_of_transfer', 'date_of_birth', 'image', 'sign', 'current_address', 
        'office_phone', 'office_address', 'is_activated', 'is_profilechange', 
        'image_contents', 'last_login', 'last_ip', 'created_at', 'updated_at', 
        'is_admin', 'otp', 'otp_created_at', 'status', 'is_verified', 
        'office_email_id', 'is_police_staff', 'is_fix_pay_staff', 
        'police_staff_verify', 'remarks','ddo_no','cardex_no','ddo_code','tcode','dcode','session_status','session_id','from_old_awasallot_app','updated_to_new_awasallot_app'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

   

    public function tQuarterRequests()
    {
        return $this->hasMany(TQuarterRequestA::class, 'id', 'uid'); // Define the relationship
    }
    public function tQuarterRequestsb()
    {
        return $this->hasMany(TQuarterRequestb::class, 'id', 'uid'); // Define the relationship
    }

    public static function getRoleIdByTrigger($role_trigger)
    {
        $role_id = '';
        $role = self::where('is_admin', '=', true)->first();
        $role_id = $role ? $role->is_admin : '';
        return $role_id;
    }
    public function hasVerifiedPhone()
	{
	 
	  return ! is_null($this->phone_verified_at);
	}

	public function phoneVerifiedAt()
	{
	  return $this->forceFill([
		 'phone_verified_at' => $this->freshTimestamp(),
	  ])->save();
	}
	public static function post_to_url($url, $data) {
				$fields = '';
                $code = rand(1000, 9999);
                $out_put = "For Sample Testing Monitoring System, Your OTP Is: ". $code." R&B Dept., GoG.";
                $mobile=7984272117;
				/*foreach($data as $key => $value) {
				$fields .= $key . '=' . $value . '&';
				}
				rtrim($fields, '&');
			    $url="https://smsgw.sms.gov.in/failsafe/HttpLink";
			    $post = curl_init();
				curl_setopt($post,CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($post, CURLOPT_URL, $url);
				curl_setopt($post, CURLOPT_POST, count($data));
				curl_setopt($post, CURLOPT_POSTFIELDS, $fields); 
				curl_setopt($post, CURLOPT_RETURNTRANSFER, 1);
				$result = curl_exec($post); //result from mobile seva server echo $result; //output from server displayed curl_close($post);
				//echo $result; //output from server displayed
				curl_close($post);*/
                    //sandesh app
                    $ch1 = curl_init();
                    //$out_put = "For Sample Testing Monitoring System, Your OTP Is: ". $otp." R&B Dept., GoG.";
                    curl_setopt($ch1, CURLOPT_URL, "http://localhost:8021/send?receiverid=".$mobile."&msg=".base64_encode($out_put));
                    $body = curl_exec($ch1);
                    if(strstr($body,'REJECTED') || $body == "")
                    $error = 0;
                    else
                    $error = 1;
				}
	
	public static function callToVerify1($code,$receiverNumber){
	
      /*  $message = "For Sample Testing Monitoring System, Your OTP Is: ". $code." R&B Dept., GoG.";
		  
      try {
			header('Content-Type: text/html;');
			$username="rbdg.sms"; //username of the department
			$password="K%215Ej3D%252h"; //password of the department
			$senderid="GUJGOV"; //senderid of the deparment
			$message=$message; //message content
			//$mobileno="7984272117"; //if single sms need to be send use mobileno keyword
			$mobileno=$receiverNumber;
		
			$templateid="1007289742492033341";
			
			

			$data = array(
			"username" => trim($username), 
			"pin" => trim($password),
			"message" => trim($message),
            "number" =>trim($mobileno), 
			"signature" =>"OSDRNB", 
			"dlt_entity_id" => trim(1001969055348815316),
			"dlt_template_id"=>1007718968732387685
			);
			User::post_to_url("https://smsgw.sms.gov.in/failsafe/HttpLink",$data);
				
        } catch (Exception $e) {
            info("Error: ". $e->getMessage());
        }*/
        $ch1 = curl_init();
         $receiverNumber.$out_put = "For Sample Testing Monitoring System, Your OTP Is: ". $code." R&B Dept., GoG.";
        curl_setopt($ch1, CURLOPT_URL, "http://localhost:8021/send?receiverid=".$receiverNumber."&msg=".base64_encode($out_put));
        $body = curl_exec($ch1);
        if(strstr($body,'REJECTED') || $body == "")
        $error = 0;
        else
        $error = 1;
		
	}
	public static function callToVerify()
    {
        
       $code = rand(1000, 9999);
	   $code=1234;
	

User::updateOrCreate(
    ['id' => auth()->user()->id], // Attributes to find the user
    [ // Attributes to update or create
        'otp' => $code,
       
    ]
);


        $receiverNumber = auth()->user()->contact_no;
		//dd(auth()->user());
		User::callToVerify1( $code,$receiverNumber);
     
    }
    public function sendEmailVerificationNotification()
{
    $this->notify(new CustomVerifyEmail);
}
    

 // Relationship to UserHistory
    public function histories()
    {
        return $this->hasMany(UserHistory::class, 'user_id', 'id');
    }

    // Method to log current state to history
    public function logHistory()
    {
       // Get only the fields that are fillable in UserHistory
        $historyFields = (new UserHistory)->getFillable();

        // Extract only matching data from current user
        $historyData = $this->only($historyFields);

        

        // Save history
        $this->histories()->create($historyData);
    }
}

