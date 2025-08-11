<?php

namespace App\Http\Controllers;

use App\User;
use App\Filelist;
use Carbon\Carbon;
use App\Couchdb\Couchdb;
use Illuminate\Http\Request;
use App\Tquarterrequestb;
use App\Tquarterrequesta;
use App\Tquarterrequestc;
use App\Quarter;
use App\PayScale;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\District;
use App\Taluka;
use Illuminate\Support\Str;

class ProfileController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $this->_viewContent['page_title'] = "Profile";
        $uid = Auth::user()->id;
        $office_email_id = Auth::user()->office_email_id;
        $is_police_staff = Auth::user()->is_police_staff;
        $basic_pay = Auth::user()->basic_pay;


        $data = User::select('updated_to_new_awasallot_app')->where('id', $uid)->first(); // to check if old user has completed profile updation or not
        if ($data['updated_to_new_awasallot_app'] == 2) {
            return  redirect()->route('user.oldprofile')->with('failed', 'Update Old Profile to Proceed');
        }

        $this->_viewContent['users'] = User::find($uid);
        $this->_viewContent['imageData'] = generateImage($uid);
        //code to display disability certificate
        $attacheddocument = DB::table('master.file_list')
            ->join('master.m_document_type', 'master.file_list.document_id', '=', 'master.m_document_type.document_type')
            ->WHERE('uid', Session::get('Uid'))
            ->WHERE('document_id', 9)
            ->select('rev_id', 'doc_id', 'document_name')
            ->first();

        //dd($attacheddocument);
        $this->_viewContent['attacheddocument'] = $attacheddocument;
        if ($basic_pay != '' && ($office_email_id == '' || $is_police_staff == '')) {
            $subqueryA = Tquarterrequesta::selectRaw('COUNT(wno) as cnt_a')
                ->where('uid', $uid)
                ->whereNotNull('wno');
            $subqueryB = Tquarterrequestb::selectRaw('COUNT(wno) as cnt_a')
                ->where('uid', $uid)
                ->whereNotNull('wno');
            $unionQuery = $subqueryA->unionAll($subqueryB);
            $result = DB::table(DB::raw("({$unionQuery->toSql()}) as a"))
                ->mergeBindings($unionQuery->getQuery())
                ->selectRaw('COALESCE(SUM(cnt_a), 0) as wno')
                ->first();
            $this->_viewContent['wno'] =  $result->wno;
            //return view('user/userprofile_email_police',$this->_viewContent);
            return view('user/userprofile', $this->_viewContent);
        }

        return view('user/userprofile', $this->_viewContent);
    }
    public function updateprofiledetails(Request $request)
    {
        // dd($request->all());
        $rules = [
            'name' => 'required|string',
            'office' => 'required|string',
            'office_email_id' => 'required|email|regex:/^[a-zA-Z0-9._%+-]+@gujarat\.gov\.in$/',
            'is_dept_head' => 'required',
            'is_transferable' => 'required',
            'date_of_birth' => 'required',
            'appointment_date' => 'required',
            'date_of_retirement' => 'required',
            'salary_slab' => 'required',
            'grade_pay' => 'required',
            'basic_pay' => 'required',
            'address' => 'required',
            'current_address' => 'required',
            'office_phone' => 'required',
            'office_address' => 'required',
            'is_police_staff' => 'required',
            'is_fix_pay_staff' => 'required',
            'is_judge' => 'required',
            'is_phy_dis' => 'required',
            'dis_per' => 'nullable|numeric|max:100|regex:/^\d+(\.\d{1,3})?$/'
        ];
        $messages = [
            'name.required' => 'The name field is required.',
            'name.string' => 'The name must be a valid string.',
            'office.required' => 'The office field is required.',
            'office.string' => 'The office must be a valid string.',
            'office_email_id.required' => 'The office email is required',
            'office_email_id.email' => 'The office email must be valid email address',
            'is_dept_head.required' => 'The department head status is required.',
            'is_transferable.required' => 'The transferability status is required.',
            'date_of_birth.required' => 'The Date of Birth is required.',
            'appointment_date.required' => 'The appointment date is required.',
            'date_of_retirement.required' => 'The date of retirement is required.',
            'salary_slab.required' => 'The salary slab is required.',
            'grade_pay.required' => 'The grade pay is required.',
            'basic_pay.required' => 'The basic pay is required.',
            'address.required' => 'The address field is required.',
            'current_address.required' => 'The current address field is required.',
            'office_phone.required' => 'The office phone number is required.',
            'office_address.required' => 'The office address is required.',
            'is_police_staff.required' => 'The Police Staff  is required.',
            'is_fix_pay_staff.required' => 'The Fix Pay Staff   is required.',
            'dis_per.numeric' => 'The disability percentage must be a numeric value.',
            'dis_per.regex' => 'The disability percentage must be a valid number (up to three decimal places).',
        ];
        $validator =  \Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            // return redirect('profile')
            //     ->withInput()
            //     ->withErrors($validator);
            return redirect()->back()
                ->withInput()
                ->withErrors($validator);
        } else {
            $data = $request->input();
            try {
                $uid = Session::get('Uid');
                if (isset($request->oldprofile) && $request->oldprofile == 1) {
                    $basic_pay = $request->get('basic_pay');
                    $q_officecode = Session::get('q_officecode');
                    $quartertype = Quarter::select('quartertype')->where('bpay_from', '<=', $basic_pay)->where('bpay_to', '>=', $basic_pay)->where('officecode', $q_officecode)->first();
                    if (!$quartertype) {
                        return redirect()->back()->with('failed', 'Provide correct/updated basic pay details');
                    }
                }
                if ($request->hasFile('image')) {

                    $docId = (string)Session::get('Uid') . "_0_photo";
                    //uploadDocuments($docId,$request);
                    uploadDocuments($docId, $request->file('image'));
                }
                $appointment_date = Carbon::createFromFormat('d-m-Y', $request->get('appointment_date'));
                $date_of_retirement = Carbon::createFromFormat('d-m-Y', $request->get('date_of_retirement'));
                $date_of_birth = Carbon::createFromFormat('d-m-Y', $request->get('date_of_birth'));
                // Enable query logging
                // DB::enableQueryLog();
                $updateData = [
                    'name' => empty($request->get('name')) ? NULL : $request->get('name'),
                    'designation' => empty($request->get('designation')) ? NULL :  $request->get('designation'),
                    'office' => empty($request->get('office')) ? NULL : $request->get('office'),
                    'office_email_id' => empty($request->get('office_email_id')) ? NULL : $request->get('office_email_id'),
                    'contact_no' => empty($request->get('contact_no')) ? NULL :  $request->get('contact_no'),
                    'maratial_status' => empty($request->get('maratial_status')) ? NULL :  $request->get('maratial_status'),
                    'is_dept_head' => empty($request->get('is_dept_head')) ? NULL :  $request->get('is_dept_head'),
                    'is_transferable' => empty($request->get('is_transferable')) ? NULL :  $request->get('is_transferable'),
                    'date_of_birth' => empty($request->get('date_of_birth')) ? NULL :  $date_of_birth->format('Y-m-d'),
                    'appointment_date' => empty($request->get('appointment_date')) ? NULL :  $appointment_date->format('Y-m-d'),
                    'date_of_retirement' => empty($request->get('date_of_retirement')) ? NULL :   $date_of_retirement->format('Y-m-d'),
                    'salary_slab' => empty($request->get('salary_slab')) ? NULL :  $request->get('salary_slab'),
                    'grade_pay' => empty($request->get('grade_pay')) ? NULL :  $request->get('grade_pay'),
                    'basic_pay' => empty($request->get('basic_pay')) ? NULL :  $request->get('basic_pay'),
                    'actual_salary' => empty($request->get('actual_salary')) ? NULL :  $request->get('actual_salary'),
                    'address' => empty($request->get('address')) ? NULL :  $request->get('address'),
                    'current_address' => empty($request->get('current_address')) ? NULL :  $request->get('current_address'),
                    'office_phone' => empty($request->get('office_phone')) ? NULL :  $request->get('office_phone'),
                    'office_address' => empty($request->get('office_address')) ? NULL :  $request->get('office_address'),
                    'gpfnumber' => empty($request->get('gpfnumber')) ? NULL :  $request->get('gpfnumber'),
                    'pancard' => empty($request->get('pancard')) ? NULL :  $request->get('pancard'),
                    'office_email_id' => empty($request->get('office_email_id')) ? NULL :  $request->get('office_email_id'),
                    'is_police_staff' => empty($request->get('is_police_staff')) ? NULL :  $request->get('is_police_staff'),
                    'is_fix_pay_staff' => empty($request->get('is_fix_pay_staff')) ? NULL :  $request->get('is_fix_pay_staff'),
                    'image' => empty($imageupload) ? NULL : $imageupload,
                    'is_judge' => empty($request->get('is_judge')) ? "N" :  $request->get('is_judge'),
                    'is_phy_dis' => empty($request->get('is_phy_dis')) ? NULL :  $request->get('is_phy_dis'),
                    'dis_per' => ($request->get('is_phy_dis') == 'N') ? 0 : (empty($request->get('dis_per')) ? 0 : $request->get('dis_per')),

                ];
                if (isset($request->oldprofile) && $request->oldprofile == 1) {
                    $updateData['updated_to_new_awasallot_app'] = 1;
                }
                // \DB::table('userschema.users')
                //     ->where('id', $uid)
                //     ->update($updateData);

                $existingUser = DB::table('userschema.users')->where('id', $uid)->first();

                if ($existingUser) {
                    // 2️ Convert stdClass to array
                    $userData = (array) $existingUser;

                    // 3️ Insert into users_history
                    \DB::table('userschema.users_history')->insert($userData);

                    // 4️ Proceed to update
                    \DB::table('userschema.users')
                        ->where('id', $uid)
                        ->update($updateData);
                } else {
                    // Handle case where user not found
                    return back()->with('error', 'User not found.');
                }

                // Get the executed queries
                //$queries = DB::getQueryLog();

                // Print the queries
                //dd($queries);

                if (!empty($request->get('basic_pay'))) {
                    Session::put('basic_pay', $request->get('basic_pay'));
                }
                if (isset($request->request_form) && $request->request_form == 'request_form') {
                    $previousUrl = url()->previous();
                    // dd($previousUrl);
                    // dd($request->all());

                    $previousUrl = url()->previous(); // Get full previous URL

                    // Parse the previous URL
                    $parsedUrl = parse_url($previousUrl);

                    // Parse query string into array
                    parse_str($parsedUrl['query'] ?? '', $queryParams);

                    // Modify/add parameters
                    $queryParams['active_tab'] = base64_encode('tab2');

                    // Rebuild query string
                    $queryString = http_build_query($queryParams);

                    // Rebuild full URL
                    $baseUrl = Str::before($previousUrl, '?');
                    $finalUrl = $baseUrl . '?' . $queryString;

                    // Redirect with updated URL and flash data
                    return redirect()
                        ->to($finalUrl)
                        ->with(['isEdit' => 1]);

                } else if (isset($request->oldprofile) && $request->oldprofile == 1) {
                    return redirect(route('user.dashboard.userdashboard'))->with('success', "Details Updated successfully");
                } else {
                    return redirect('profile')->with('success', "Details Updated successfully");
                }
            } catch (Exception $e) {
                dd($e->getMessage());
                return redirect()->back()->with('failed', "operation failed");
            }
        }
    }
    public function updateprofiledetails_email(Request $request)
    {
        $uid = Session::get('Uid');
        $rules = [
            'office_email_id' => 'required|string',
            'is_police_staff' => 'required|string',
            //   'image' => 'required|mimes:pdf|max:51200',
        ];



        $validator =  \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect('profile')
                ->withInput()
                ->withErrors($validator);
        } else {
            $data = $request->input();
            $data1['office_email_id'] = $data['office_email_id'];
            $data1['is_police_staff'] = $data['is_police_staff'];
            if ($data1['is_police_staff'] == 'Y') {
                $queryA = Tquarterrequesta::select('requestid', 'rivision_id', DB::raw("'a' as performa"))
                    ->where('uid', $uid)
                    ->whereNotNull('wno');
                // Second query using the QuarterRequestB model
                $queryB = Tquarterrequestb::select('requestid', 'rivision_id', DB::raw("'b' as performa"))
                    ->where('uid', $uid)
                    ->whereNotNull('wno');
                // Combine queries using union
                $results = $queryA->union($queryB)->get();

                $document_type = 8;
                $file = $request->file('image');
                $filesize = $file->getSize() / 1024; // Size in KB
                $filetype = $file->getMimeType();

                $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $file->getClientOriginalExtension();

                if (strpos($filename, '.') !== false) {
                    return redirect()->route('user.profile')->with('error', 'File Name should not have more than one extensions');
                }

                $fname = $filename . "-" . $uid . "-" . now()->format('dmYhis') . "." . $extension;

                $fc = file_get_contents($file->getPathname());
                $file_type = strtolower(substr($fc, 1, 3));

                if ($file_type != 'pdf') {
                    return redirect()->route('user.profile')->with('error', 'Invalid file, Please select PDF file having size less than 50KB');
                }

                foreach ($results as $row) {
                    $requestid = $row['requestid'];
                    $rivision_id = $row['rivision_id'];
                    $type = $row['performa'];
                    $docId = (string)Session::get('Uid') . "_" . $requestid . "_8_" . $type . "_" . $rivision_id;
                    //uploadDocuments($docId,$request);
                    uploadDocuments($docId, $request->file('image'));
                }
                $data1['is_police_staff'] = 1;
                $resp = User::where('id', $uid)->update($data1);
                if ($resp) {
                    // Master::log($uid, "Profile Update Success", "Profile Changes has been made successfully on " . date('d/m/Y h:i:s'));
                    return redirect()->route('user.profile')->with('success', ("Profile Updated Successfully"));
                } else {
                    // Master::log($uid, "Profile Update Failed", "Profile Changes Failed on " . date('d/m/Y h:i:s'), 'F');
                    return redirect()->route('user.profile')->with('error', ("Profile Updation Failed"));
                }
            } else {
                $resp = User::where('id', $uid)->update($data1);
                // Master::log($uid,"Profile Update Success","Profile Changes has been made successfully on ".date('d/m/Y h:i:s'));
                return redirect()->route('user.profile')->with('success', ("Profile Updated Successfully"));
                exit;
            }
        }
    }
    public function getSalarySlabDetails(Request $request)
    {

        $payLevel = $request->input('pay_level');

        $salarySlab = PayScale::select('payscale_from', 'payscale_to')->where('level', $payLevel)->first(); // Adjust according to your database structure

        if ($salarySlab) {

            return compact('salarySlab');
        } else {
            // Return a message if no details found
            return response('No salary slab details found.', 404);
        }
    }
    public function updateDDODetails(Request $request)
    {

        $basic_pay = Session::get('basic_pay');  //dd($basic_pay);
        $uid = Session::get('Uid');
        if ($basic_pay == null) {
            $data = User::select('updated_to_new_awasallot_app')->where('id', $uid)->first(); // to check if old user has completed profile updation or not
            if ($data['updated_to_new_awasallot_app'] == 2) {
                return  redirect()->route('user.oldprofile')->with('failed', 'Update Old Profile to Proceed');
            } else {
                return redirect('profile')->with('failed', "Please complete your profile.");
            }
            return view('user/updateoldprofile');
            return redirect('profile')->with('failed', "Please complete your profile.");
        } else {
            $this->_viewContent['page_title'] = 'DDO Details';
            // $this->_viewContent['page']="ddo_detail";
            $uid = Session::get('Uid');
            //dd($uid);
            $ddo_data = User::select('cardex_no', 'ddo_code')->where('id', $uid)->first();
            if ($ddo_data != null) {
                $this->_viewContent['cardex_no'] = $ddo_data['cardex_no'];
                $this->_viewContent['ddo_code'] = $ddo_data['ddo_code'];
            }
            return view('user/user_ddo_detail', $this->_viewContent);
        }

        $this->_viewContent['page_title'] = 'DDO Details';
        $this->_viewContent['page'] = "ddo_detail";
        return view('user/user_ddo_detail', $this->_viewContent);
    }
    public function updateOldProfileDetails()
    {
        return view('user/updateoldprofile');
    }
    public function viewuseroldprofile()
    {
        $uid = Session::get('Uid');
        $this->_viewContent['users'] = User::find($uid); //
        $this->_viewContent['imageData'] = generateImage($uid);
        $this->_viewContent['page_title'] = "Old Profile Verfiy and  Update";
        $this->_viewContent['isEdit'] = 0;
        $this->_viewContent['oldprofile'] = 1;
        return view('user/useroldprofile', $this->_viewContent);
    }
    public function saveOrUpdateProfileDetails(Request $request)
    {
        $rules = [
            'district' => 'required',
            'taluka' => 'required',
            'cardex_no' => 'required',
            'ddo_code' => 'required'
        ];

        $messages = [
            'district.required' => 'The district field is required.',
            'taluka.required' => 'The taluka field is required.',
            'cardex_no.required' => 'The cardex no field is required.',
            'ddo_code.required' => 'The ddo code field is required.'
        ];

        $validator = \Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->route('user.update_old_profile_details')
                ->withInput()
                ->withErrors($validator);
        }

        try {
            $isAdminUpdate = $request->has('user_id');
            $uid = $isAdminUpdate ? base64_decode($request->input('user_id')) : Session::get('Uid');

            $cardex_no = $request->input('cardex_no');
            $ddo_code = $request->input('ddo_code');

            $updateData = [
                'dcode' => $request->input('district'),
                'tcode' => $request->input('taluka'),
                'cardex_no' => $cardex_no,
                'ddo_code' => $ddo_code
            ];

            if (!$isAdminUpdate) {
                $updateData['updated_to_new_awasallot_app'] = 2;
            }

            $resp = \DB::table('userschema.users')->where('id', $uid)->update($updateData);

            foreach ([Tquarterrequesta::class, Tquarterrequestb::class, Tquarterrequestc::class] as $model) {
                $requests = $model::select('requestid')->where('uid', $uid)->get();
                foreach ($requests as $row) {
                    $model::where('requestid', $row->requestid)->update([
                        'cardex_no' => $cardex_no,
                        'ddo_code' => $ddo_code
                    ]);
                }
            }

            if ($resp) {
                return $isAdminUpdate
                    ? redirect()->route('user')->with('success', 'Details Updated Successfully')
                    : redirect()->route('user.dashboard.userdashboard')->with('success', 'Profile Updated Successfully');
            } else {
                return redirect()->back();
            }
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
    public function getTalukasByDistrict(Request $request)
    {

        $dcode = $request->input('dcode');
        //dd($dcode);
        // Validate the input
        if (!$dcode) {
            return response()->json([], 400); // Return empty if dcode is not valid
        }

        // Fetch talukas by district code (assuming you have a Taluka model with a dcode foreign key)
        $talukas = Taluka::where('dcode', $dcode)->get(['tcode', 'name_g', 'name_e']);

        return response()->json($talukas);
    }
}
