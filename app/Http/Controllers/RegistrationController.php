<?php

namespace App\Http\Controllers;
use App\User;
use App\Designationlevel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use SoapClient;
use Session;
use Illuminate\Support\Facades\Auth;
class RegistrationController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function apiLogin(Request $request){
      //   dd($request->has('gid'));
         if(($request->has('gid') && $request->get('gid') != '') || \Auth::check())
         {
               $gid = $request->get('gid');
                 //try{
                    $url = config('app.url');
                    //dd($url);
                    $soap_service_url = config('app.soap_service_url');
                    //dd($soap_service_url);
                    $client = new \SoapClient($soap_service_url);
                    //dd($url);
                     $resp =  $client->IsValidTokan(array('GId' => $gid,'AppURL' =>  $url));

                     $uid = $resp->IsValidTokanResult;
                     //dd($resp,$uid);
                     if(!$uid){
                         throw new \Exception('Invalid uid'); 
                        }
            // }
              $usercheck= User::where('usercode', '=',$uid)->count();
             // dd($uid);
              $Designationlevel= Designationlevel::pluck('designationcode')->toArray();
          //  $Designationlevel = array_values($Designationlevel);

             if($usercheck == 1)
             {
                 $user = User::where('usercode',$uid)->where('is_admin',true)->first();
                // dd($user->is_admin);
               //  $is_admin = true;
                // dd(Auth::user()->is_admin);
                 Session::put('is_admin',$user->is_admin);
                    $role_name = $user->is_admin ? 'admin' : 'user';
                    // Store the role in the session
                 session(['role' => $role_name]);
                 \Auth::login($user);
                 $tokenObj = $client->GetLiveTokan(array('UserID' => $uid,'AppURL' =>  $url));
                 $token = $tokenObj->GetLiveTokanResult;
                 $userdet=$client->getUser(array('UserID'=>$uid,'enc_tokan'=> $token));
                 $userdet2=get_object_vars($userdet->getUserResult);
                 $office_designations = array();

                foreach($userdet2 as $name => $temp)
                {
                    $i = 0;
                    if(is_countable($temp) && count($temp)>1)
                    {
                         foreach($temp as $item)
                         {
                            $ttt = (array) $item;
                            if(in_array($ttt['DesignationCode'],$Designationlevel)) 
							{
								 $office_designations[$i]['empname'] = $ttt['FullName'];
								 $office_designations[$i]['officecode'] = $ttt['OfficeCode'];
								 $office_designations[$i]['designationcode'] = $ttt['DesignationCode'];
								 $office_designations[$i]['districtcode'] = $ttt['DistID'];
								 $office_designations[$i]['officename'] = $ttt['Office_Eng'];
								 $office_designations[$i]['designation'] = $ttt['Designation_Eng'];
								 $office_designations[$i]['districteng'] = $ttt['District_Eng'];
								 $office_designations[$i]['deptid'] = $ttt['DeptID'];
								 $office_designations[$i] = (object) $office_designations[$i];
								 $i++;
                             }
                         }
                    }
                    else
                    {
						$ttt = (array) $temp;
						$ttt = (array) $item;
						if(in_array($ttt['DesignationCode'],$Designationlevel)) 
						{  
							$dlevel = DB::table('master.designationlevel')
							->where('designationcode', '=', $ttt['DesignationCode'])
							->select('level')
							->first();
							$dlevel1 = $dlevel ? $dlevel->level : "4";
							Session::put('empname', strip_tags($ttt['FullName']));
							Session::put('officecode', strip_tags($ttt['OfficeCode']));
							Session::put('designationcode', strip_tags($ttt['DesignationCode']));
							Session::put('districtcode', strip_tags($ttt['DistID']));
							Session::put('officeeng', strip_tags($ttt['Office_Eng']));
							Session::put('desigeng', strip_tags($ttt['Designation_Eng']));
							Session::put('districteng', strip_tags($ttt['District_Eng']));
							Session::put('deptid', strip_tags($ttt['DeptID']));
							Session::put('s_level', $dlevel1);
							$yearcheck = Carbon::now()->month;
							if ($yearcheck > 3) { // If the month is after March
							$syear = Carbon::now()->year; // Start year
							$eyear = $syear + 1; // End year
							$finYear = $syear . substr($eyear, -2); // Financial year format (e.g., "202122")
							} else { 
							$syear = Carbon::now()->year - 1; 
							$eyear = Carbon::now()->year; // End year
							$finYear = $syear . substr($eyear, -2); // Financial year format
							}
							Session::put('fin_year', $finYear);
							log_activity('admin login', 'admin login', null, ['additional' => auth()->user()]);
							return redirect('home');
						}
                    }
                }
                 //dd($office_designations);
                 return view('checkuser', ['office_designations' => $office_designations]);
             }
             else{
            Session::put('uid',$uid);
            Session::put('is_admin',True);
             return view('ssouserregister');
             }
 
         }

 }


}
