<?php

namespace App\Http\Controllers;
use App\Tquarterrequestb;
use App\Tquarterrequesta;
use App\User;
use App\Remarks;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use DB;
use App\Filelist;
class PolicestaffController extends Controller
{
    public  function index()
    {
        $this->_viewContent['page_title'] = "Quarter Priority";
        return view('police/index',$this->_viewContent);
    }
    public function getpolicedocumentList(Request $request)
    {

        $annexureAObj = Tquarterrequesta::with(['usermaster' => function($query) {
            $query->select(['id', 'name', 'office', 'contact_no', 'email'])
                  ->where('police_staff_verify', 1)->where('is_police_staff', 'Y');

        }])
        ->whereHas('usermaster', function ($query) {
            $query->where('police_staff_verify', 1);
            $query->where('is_police_staff', 'Y');
           // $query->where('is_priority', 'N');
           // $query->where('is_varified', 1);
          //  $query->whereNotNull('wno');

        })
        ->where('is_accepted', 1)->where('is_priority', 'N')->where('is_varified', 1)->whereNotNull('wno')
        ->select(['uid', 'requestid', 'quartertype', 'remarks', 'request_date', 'wno', 'inward_no', 'rivision_id', 'inward_date',DB::raw("'New' as tableof")])
        ;


          // \DB::enableQueryLog();
        // Retrieve data from TQuarterRequestB
        $annexureBObj = TQuarterRequestb::with(['usermaster' => function($query) {
            $query->select(['id', 'name', 'office', 'contact_no', 'email'])
                  ->where('police_staff_verify', 1)->where('is_police_staff', 'Y');
        }])
        ->whereHas('usermaster', function ($query) {
            $query->where('police_staff_verify', 1);
            $query->where('is_police_staff', 'Y');
        })
        ->where('is_accepted', 1)->where('is_priority', 'N')->where('is_varified', 1)->whereNotNull('wno')
        ->select(['uid', 'requestid', 'quartertype', 'remarks', 'request_date', 'wno', 'inward_no', 'rivision_id', 'inward_date',DB::raw("'Upgrade' as tableof")]);
       // dd( \DB::getQueryLog());
        // Combine both datasets
        $combinedResults = $annexureAObj->union($annexureBObj)->get();
       // dd($combinedResults);
        //echo "<pre>";print_r($combinedResults); exit;
        return DataTables::of($combinedResults)
                ->addColumn('UserName', function($row) {
                    return optional($row->usermaster)->name;
                })
                ->addColumn('UserOffice', function($row) {
                    return optional($row->usermaster)->office;
                })
                ->addColumn('UserContactNo', function($row) {
                    return optional($row->usermaster)->contact_no;
                })
                ->addColumn('UserEmailId', function($row) {
                    return optional($row->usermaster)->email;
                })
            ->addColumn('inward_date', function ($data) {
                return ($data->inward_date) ? date('d-m-Y', strtotime($data->inward_date)) : 'N/A';
            })
            ->addColumn('request_date', function ($data) {
                return ($data->request_date) ? date('d-m-Y', strtotime($data->request_date)) : 'N/A';
            })
            ->addColumn('action', function ($row) {
                if($row->tableof=='New')
        { //console.log($row->tableof);
        //  $btn1 = '<a href="'.\route('editquarter', $row->requestid).'" class="btn btn-success "><i class="fas fa-edit"></i></a> ';
        $btn1 = '<a href="'.route('editquarter_police_a', [
            'r' => $row->requestid,
            'rv' => $row->rivision_id,
            'performa' => 'a'
        ]).'" class="btn btn-success "><i class="fas fa-edit"></i></a>';   }
        else
        {
            $btn1 = '<a href="'.route('editquarter_police_a', [
                'r' => $row->requestid,
                'rv' => $row->rivision_id,
                'performa' => 'b'
            ]).'" class="btn btn-success "><i class="fas fa-edit"></i></a>';

        }
        return $btn1;   })
            ->rawColumns(['action'])
            ->make(true);
    }
    public function editquarter_a(Request $request, $requestid, $rivision_id,  $performa)
    {

        if($performa=='a')
        {
            $req_uid = TQuarterRequesta::where('requestid', $requestid)
            ->select('uid')
            ->first();

            $request = TQuarterRequesta::with(['usermaster' => function ($query) {
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
                'downgrade_allotment', 'request_date', 'inward_no', 'inward_date', 'is_varified','requestid','rivision_id','dgrid'
            ])
            ->where('requestid', $requestid)
            ->where('rivision_id', $rivision_id)
            ->first();
            $this->_viewContent['quarterrequest1'] = Tquarterrequesta::select(['request_date','requestid','quartertype','inward_no','inward_date','rivision_id','remarks',
            'is_accepted','is_allotted','is_varified'])
            ->where('requestid','=',$requestid)
            ->where('uid','=',$request->uid)
            ->get();

        }
        else
        {
            $req_uid = TQuarterRequestb::where('requestid', $requestid)
            ->select('uid')
            ->first();
            $request = TQuarterRequestb::with(['usermaster' => function ($query) {
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
                'downgrade_allotment', 'request_date', 'inward_no', 'inward_date', 'is_varified','requestid','rivision_id','dgrid'
            ])
            ->where('requestid', $requestid)
            ->where('rivision_id', $rivision_id)
            ->first();
            $this->_viewContent['quarterrequest1'] = Tquarterrequestb::select(['request_date','requestid','quartertype','inward_no','inward_date','rivision_id','remarks',
            'is_accepted','is_allotted','is_varified'])
            ->where('requestid','=',$requestid)
            ->where('uid','=',$request->uid)
            ->get();
        }
        $this->_viewContent['file_uploaded'] = Filelist::select(['document_id','rev_id','doc_id','document_name'])
        ->join('master.m_document_type as  d', 'd.document_type', '=', 'master.Filelist.document_id')
        ->where('request_id','=',$requestid)
        ->where('rivision_id','=', $rivision_id)
        ->where('master.Filelist.performa','=',$performa)
        ->get();
        $remarks =  Remarks::where('rtype', '1')->get();
        $this->_viewContent['remarks']=$remarks;
        $this->_viewContent['quarterrequest']=(isset($request) && isset($request))?$request:'';
        $this->_viewContent['page_title'] = " Edit Quarter Details";
        return view('police/updatequarterrequest',$this->_viewContent);
    }
    public function  saveapplication (request $request)
    {
        $status = $request->input('status');
        $uid = base64_decode($request->input('uid'));
        $remarks = $request->input('remarks');
        $other_remarks = $request->input('other_remarks');
        $requestid = $request->input('requestid');
        $rivision_id = $request->input('rv');
        DB::enableQueryLog();
    //    DB::beginTransaction();

        try {
            if ($status == '1') {
                $data['police_staff_verify'] = 2;
                User::where('id', $uid)->update($data);
                return redirect()->route('quarter.police.document')->with('success', 'Request Verified Successfully');
            } else { //echo strstr($remarks, 'O');exit;
                if (strstr($remarks, 'O')) {
                    $remarksObj = new Remarks();
                    $remarksObj->description = $other_remarks;
                    $remarksObj->rtype = '1';
                    $remarksObj->save();
                    if ($remarksObj->save()) {
                        //dd("Save was successful");
                       $remark_id = Remarks::where('rtype', '1')
                            ->orderBy('remark_id', 'desc')
                            ->first()
                            ->remark_id;
                        $remarks = str_ireplace("O", $remark_id, $remarks);
                    } else {
                        // Save failed, handle the error
                        return redirect()->back()->with('error', 'Unable to save the remark. Please try again.');
                    }
                }

                $data1 = [
                    'remarks' => rtrim($remarks, ","),
                    'police_staff_verify' => 3
                ];
                $resp = User::where('id', $uid)
                    ->where('is_police_staff', 'Y')
                    ->update($data1);
                if ($resp) {
                    $users = User::where('id', $uid)->first();
                    $email = $users->email;

                    $msg = "Police certificate Request $requestid/ has been refused with remarks successfully on " . date('d/m/y h:i:s');
                    $subject = "Awas Allot Portal";

                    // Send email
                  /*  Mail::raw($msg, function ($message) use ($email, $subject) {
                        $message->to($email)
                            ->subject($subject);
                    });*/

                 //   $this->logAction($userid, "Police certificate Request Processed Successfully", "Request $requestid/$type has been refused with remarks successfully on " . date('d/m/y h:i:s'));
                 //   $this->notifyUser($uid, "Police certificateRequest with inward no : $inward_no has been refused with remarks successfully. Kindly check <a href='".route('front_links')."'>Quarter Request</a> section for further details");

                   // DB::commit();
                    return redirect()->route('quarter.police.document')->with('success', 'Police staff Certificate updated successfully');
                } else {
                    $this->logAction($uid, "Quarter Request Process Failed", "Quarter Request Process failed at remarks page on " . date('d/m/y h:i:s'), "F");
                    DB::rollBack();
                   // return redirect()->route('quarterallotment')->with('error', 'Unable to process request please try again later')->with('requestid', $requestid)->with('type', strtolower($type));
                }
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('quarter.police.document')->with('error', 'An error occurred, please try again.')->with('requestid', $requestid)->with('rivision_id', $rivision_id);
        }
    }


}
