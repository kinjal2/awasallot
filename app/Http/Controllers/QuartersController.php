<?php

namespace App\Http\Controllers;

use Validator, Redirect, Response;
use Illuminate\Http\Request;
use App\Tquarterrequestb;
use App\Tquarterrequesta;
use App\Tquarterrequestc;
use App\Documenttype;
use App\QuarterType;
use App\Filelist;
use App\Quarter;
use App\Remarks;
use App\User;
use App\Area;
use App\DDOCode;
use App\QuarterAllotment;
use App\Tquarterequesthistorya;
use App\Tquarterrequesthistoryb;
use Carbon\Carbon;
use Session;
use Yajra\Datatables\Datatables;
use DB;
use Mpdf\Mpdf;
use Mpdf\Config\ConfigVariables;
use Mpdf\Config\FontVariables;
use App\Couchdb\Couchdb;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;

use stdClass;

class QuartersController extends Controller
{
    var $viewContent = [];
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {


        $uid = Session::get('Uid');

        $basic_pay = Session::get('basic_pay');
        $q_officecode = Session::get('q_officecode');


        $basic_pay = Session::get('basic_pay');  //dd($basic_pay);
        $data = User::select('updated_to_new_awasallot_app')->where('id', $uid)->first(); // to check if old user has completed profile updation or not
        if ($basic_pay == null) {

            if ($data['updated_to_new_awasallot_app'] == 2) {
                return  redirect()->route('user.oldprofile')->with('failed', 'Update Old Profile to Proceed');
            } else {
                return redirect('profile')->with('failed', "Please complete your profile.");
            }
        } else {
            $this->_viewContent['page_title'] = "Quarter History";
            return view('user/historyQuarter', $this->_viewContent);
        }
    }
    public function requestnewquarter()
    {

        $uid = Session::get('Uid');
        $basic_pay = Session::get('basic_pay');  //dd($basic_pay);
        $q_officecode = Session::get('q_officecode');
        //dd($basic_pay,$q_officecode);
        // session(['officecode' => $data->officecode]);
        $officecode = session('officecode');
        //session(['cardex_no' => $data->cardex_no]);
        $cardex_no = session('cardex_no');
        //session(['ddo_code' => $data->ddo_code]);
        $ddo_code = session('ddo_code');
        //dd($officecode,$cardex_no,$ddo_code,$basic_pay,$q_officecode);
        if ($basic_pay == null) {

            $data = User::select('updated_to_new_awasallot_app')->where('id', $uid)->first(); // to check if old user has completed profile updation or not
            if ($data['updated_to_new_awasallot_app'] == 2) {
                return  redirect()->route('user.oldprofile')->with('failed', 'Update Old Profile to Proceed');
            } else {
                return redirect('profile')->with('failed', "Please complete your profile.");
            }
        } else if ($basic_pay != null && $cardex_no == null && $ddo_code == null && $officecode == null) //21-01-2025
        {

            $this->_viewContent['page_title'] = "DDO Details";
            $this->_viewContent['page'] = "new_request";
            return view('user/user_ddo_detail', $this->_viewContent);
        }
        //4/1/2025
        else if ($basic_pay != null && $q_officecode == null) {
            $this->_viewContent['page_title'] = "Quarter Request";
            $this->_viewContent['quartertype'] = 'J';
            return view('user/newQuarterRequest', $this->_viewContent);
        } else {
            //$quarterselect = Quarter::where('bpay_from', '<=', $basic_pay)->where('bpay_to', '>=', $basic_pay)->get();
            $quarterselect = Quarter::where('bpay_from', '<=', $basic_pay)->where('bpay_to', '>=', $basic_pay)->where('officecode', $q_officecode)->get();
            $quarterrequesta = Tquarterrequesta::where('uid', '=', $uid)->where('quartertype', '=', $quarterselect[0]->quartertype)->get();
            $quarterrequestcheck = $quarterrequesta->count();
            if ($quarterrequestcheck > 0) {
                return redirect('userdashboard')->with('message', "You have been registered for a new quarter request.");
            } else {
                $this->_viewContent['page_title'] = "Quarter Request";
                $this->_viewContent['name'] = Session::get('Name');
                $this->_viewContent['quartertype'] = $quarterselect[0]->quartertype;
                return view('user/newQuarterRequest', $this->_viewContent);
            }
        }
    }
    public function requesthighercategory()
    {
        $uid = Session::get('Uid');
        $basic_pay = Session::get('basic_pay');
        $q_officecode = Session::get('q_officecode');
        // session(['officecode' => $data->officecode]);
        $officecode = session('officecode');
        //session(['cardex_no' => $data->cardex_no]);
        $cardex_no = session('cardex_no');
        //session(['ddo_code' => $data->ddo_code]);
        $ddo_code = session('ddo_code');
        //dd($officecode,$cardex_no,$ddo_code);
        if ($basic_pay == null) {
            $data = User::select('updated_to_new_awasallot_app')->where('id', $uid)->first(); // to check if old user has completed profile updation or not
            if ($data['updated_to_new_awasallot_app'] == 2) {
                return  redirect()->route('user.oldprofile')->with('failed', 'Update Old Profile to Proceed');
            } else {
                return redirect('profile')->with('failed', "Please complete your profile.");
            }
        } else if ($basic_pay != null && $cardex_no == null && $ddo_code == null && $officecode == null) //21-01-2025
        {

            $this->_viewContent['page_title'] = "DDO Details";
            $this->_viewContent['page'] = "higher_request";
            return view('user/user_ddo_detail', $this->_viewContent);
        } else if ($basic_pay != null && $q_officecode == null) {
            $this->_viewContent['page_title'] = "Higher Category";
            $this->_viewContent['quartertype'] = 'j';
            return view('user/higherCategoryQuarterRequest', $this->_viewContent);
        } else {
            //$quarterselect = Quarter::where('bpay_from', '<=', $basic_pay)->where('bpay_to', '>=', $basic_pay)->get();
            $quarterselect = Quarter::where('bpay_from', '<=', $basic_pay)->where('bpay_to', '>=', $basic_pay)->where('officecode', $q_officecode)->get();
            $quarterrequesta = Tquarterrequestb::where('uid', '=', $uid)->where('quartertype', '=', $quarterselect[0]->quartertype)->get();
            $quarterrequestcheck = $quarterrequesta->count();
            // dd($quarterrequestcheck);
            if ($quarterrequestcheck > 0) {
                return redirect('userdashboard')->with('message', "You have been registered for a higher category quarter request.");
            } else {
                $this->_viewContent['page_title'] = "Higher Category";
                $this->_viewContent['quartertype'] = $quarterselect[0]->quartertype;
                $this->_viewContent['name'] = Session::get('Name');
                return view('user/higherCategoryQuarterRequest', $this->_viewContent);
            }
        }
    }
    public function saveHigherCategoryReq(Request $request)
    {

        $rules = [
            'quartertype' => 'required|string',
            'prv_quarter_type' => 'required|string',
            'prv_area' => 'required',
            'prv_blockno' => 'required',
            'prv_unitno' => 'required',
            'prv_allotment_details' => 'required',
            'prv_possession_date' => 'required',
            'have_hc_quarter_yn' => 'required',
            /*   'hc_quarter_type' => 'required',
            'hc_area' => 'required',
            'hc_unitno'=>'required',
            'hc_allotment_details'=>'required',*/
            'agree_rules' => 'required',
            'declaration' => 'required',
            //4/1/2025
            // 'cardex_no' => 'required',
            //'ddo_code' => 'required',

        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect('quartershigher')
                ->withInput()
                ->withErrors($validator);
        } else {
            $data = $request->input();
            //  dd($data);
            $prv_possession_date = Carbon::createFromFormat('d-m-Y', $request->get('prv_possession_date'));
            $request_id = Tquarterrequestb::max('requestid');
            if (!$request_id)
                $request_id = 0;
            $request_id += 1;
            try {
                $uid = Session::get('Uid');
                $officecode = Session::get('officecode');
                $Tquarterrequestb = new Tquarterrequestb;
                $Tquarterrequestb->requestid = $request_id;
                $Tquarterrequestb->rivision_id = 0;
                $Tquarterrequestb->quartertype = empty($request->get('quartertype')) ? NULL : $request->get('quartertype');
                $Tquarterrequestb->uid = $uid;
                $Tquarterrequestb->prv_quarter_type = empty($request->get('prv_quarter_type')) ? NULL : $request->get('prv_quarter_type');
                $Tquarterrequestb->prv_area = empty($request->get('prv_area')) ? NULL : $request->get('prv_area');
                $Tquarterrequestb->prv_blockno = empty($request->get('prv_blockno')) ? NULL : $request->get('prv_blockno');
                $Tquarterrequestb->prv_unitno = empty($request->get('prv_unitno')) ? NULL : $request->get('prv_unitno');
                $Tquarterrequestb->prv_details = empty($request->get('prv_allotment_details')) ? NULL : $request->get('prv_allotment_details');
                $Tquarterrequestb->prv_possession_date = empty($request->get('prv_possession_date')) ? NULL : $prv_possession_date->format('Y-m-d');
                $Tquarterrequestb->is_hc = empty($request->get('have_hc_quarter_yn')) ? 0 : 1;
                $Tquarterrequestb->hc_quarter_type = empty($request->get('hc_quarter_type')) ? NULL : $request->get('hc_quarter_type');
                $Tquarterrequestb->hc_area = empty($request->get('hc_area')) ? NULL : $request->get('hc_area ');
                $Tquarterrequestb->hc_blockno = empty($request->get('hc_blockno')) ? NULL : $request->get('hc_blockno');
                $Tquarterrequestb->hc_unitno = empty($request->get('hc_unitno')) ? NULL : $request->get('hc_unitno');
                $Tquarterrequestb->hc_details = empty($request->get('hc_allotment_details')) ? NULL : $request->get('hc_allotment_details');
                //$Tquarterrequestb->is_accepted = empty($request->get('agree_rules')) ? 0 : 1;
                $Tquarterrequestb->request_date = date('Y-m-d');
                //3/1/2025
                $Tquarterrequestb->cardex_no = session('cardex_no');
                $Tquarterrequestb->ddo_code = session('ddo_code');
                $Tquarterrequestb->officecode = $officecode;
                //23-1-2025
                $Tquarterrequestb->choice1 = empty($request->get('choice1')) ? NULL : $request->get('choice1');
                $Tquarterrequestb->choice2 = empty($request->get('choice2')) ? NULL : $request->get('choice2');
                $Tquarterrequestb->choice3 = empty($request->get('choice3')) ? NULL : $request->get('choice3');
                $Tquarterrequestb->save();
                //session()->forget(['cardex_no', 'ddo_code']);
                return redirect()->back()->withErrors('message', 'IT WORKS!');
            } catch (Exception $e) {
                return redirect('insert')->with('failed', "operation failed");
            }
        }
    }
    public function saveNewRequest(Request $request)
    {
        $rules = [
            'quartertype' => 'required|string',
            'deputation_date' => 'required',
            //'old_desg' => 'required',
            'deputation_yn' => 'required',
            //'old_office' => 'required',
            //'prv_rent' => 'required',
            //'prv_building_no' => 'required',
            'old_allocation_yn' => 'required',
            //'prv_quarter_type' => 'required',
            'prv_handover' => 'required',
            //'prv_area_name'=>'required',
            'have_old_quarter_yn' => 'required',
            'is_relative_yn' => 'required',
            //'relative_details' => 'required',
            'is_stsc_yn' => 'required',
            //'scst_details'=>'required',
            'is_relative_house_yn' => 'required',
            //'relative_house_details' => 'required',
            'have_house_nearby_yn' => 'required',
            //'nearby_house_details'=>'required',
            'downgrade_allotment' => 'required',
            'agree_rules' => 'required',
            'choice1' => 'required',
            'choice2' => 'required',
            'choice3' => 'required',

            'agree_rules' => 'required',
            'declaration' => 'required'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect('quartersuser')
                ->withInput()
                ->withErrors($validator);
        } else {
            $data = $request->input();
            // dd($data);
            $officecode = Session::get('officecode');
            //dd($officecode);
            $deputation_date = Carbon::createFromFormat('d-m-Y', $request->get('deputation_date'));
            $request_id = Tquarterrequesta::max('requestid');
            if (!$request_id)
                $request_id = 0;
            $request_id += 1;
            try {
                $uid = Session::get('Uid');
                $Tquarterrequesta = new Tquarterrequesta;
                $Tquarterrequesta->requestid = $request_id;
                $Tquarterrequesta->quartertype = empty($request->get('quartertype')) ? NULL : $request->get('quartertype');
                $Tquarterrequesta->old_designation = empty($request->get('old_desg')) ? NULL : $request->get('old_desg');
                $Tquarterrequesta->old_office = empty($request->get('old_office')) ? NULL : $request->get('old_office');
                $Tquarterrequesta->deputation_date = empty($request->get('deputation_date')) ? NULL : $deputation_date->format('Y-m-d');
                $Tquarterrequesta->prv_area_name = empty($request->get('prv_area_name')) ? NULL : $request->get('prv_area_name');
                $Tquarterrequesta->prv_building_no = empty($request->get('prv_building_no')) ? NULL : $request->get('prv_building_no');
                $Tquarterrequesta->prv_quarter_type = empty($request->get('prv_quarter_type')) ? NULL : $request->get('prv_quarter_type');
                $Tquarterrequesta->prv_rent = empty($request->get('prv_rent')) ? NULL : $request->get('prv_rent');
                $Tquarterrequesta->prv_handover = empty($request->get('prv_handover')) ? NULL : $request->get('prv_handover');
                $Tquarterrequesta->have_old_quarter = empty($request->get('have_old_quarter_yn')) ? NULL : $request->get('have_old_quarter_yn');
                $Tquarterrequesta->is_scst = empty($request->get('is_scst')) ? NULL : $request->get('is_scst');
                $Tquarterrequesta->scst_info = empty($request->get('scst_details')) ? NULL : $request->get('scst_details');
                $Tquarterrequesta->is_relative = empty($request->get('is_relative')) ? NULL : $request->get('is_relative');
                $Tquarterrequesta->relative_details = empty($request->get('relative_details')) ? NULL : $request->get('relative_details');
                $Tquarterrequesta->is_relative_householder = empty($request->get('is_relative_house')) ? NULL : $request->get('is_relative_house');
                $Tquarterrequesta->relative_house_details = empty($request->get('relative_house_details')) ? NULL : $request->get('relative_house_details');
                $Tquarterrequesta->have_house_nearby = empty($request->get('have_house_nearby')) ? NULL : $request->get('have_house_nearby');
                $Tquarterrequesta->nearby_house_details = empty($request->get('nearby_house_details')) ? NULL : $request->get('nearby_house_details');
                $Tquarterrequesta->downgrade_allotment = empty($request->get('downgrade_allotment')) ? NULL : $request->get('downgrade_allotment');
                $Tquarterrequesta->request_date = date('Y-m-d');
                $Tquarterrequesta->is_downgrade_request = 0;
                $Tquarterrequesta->is_priority = 'N';
                $Tquarterrequesta->uid = $uid;
                $Tquarterrequesta->officecode = $officecode;
                $Tquarterrequesta->choice1 = $request->get('choice1');
                $Tquarterrequesta->choice2 = $request->get('choice2');
                $Tquarterrequesta->choice3 = $request->get('choice3');
                //3/1/2025
                $Tquarterrequesta->cardex_no = session('cardex_no');
                $Tquarterrequesta->ddo_code = session('ddo_code');
                $Tquarterrequesta->save();
                //session()->forget(['cardex_no', 'ddo_code']);
                return redirect('quartersuser')->with('Success', "Data Saved Successfully");
            } catch (Exception $e) {
                return redirect('insert')->with('failed', "operation failed");
            }
        }
    }
    public function requestHistory(Request $request)
    {
        $uid = Session::get('Uid');

        $basic_pay = Session::get('basic_pay');
        $q_officecode = Session::get('q_officecode');
        
             //query for office for gandhinagara and other district
        $quarterselect = Quarter::where('bpay_from', '<=', $basic_pay)->where('bpay_to', '>=', $basic_pay)->where('officecode', $q_officecode)->get();
        //dd($quarterselect);

       //    DB::enableQueryLog();
        $quarterlist = Tquarterrequestc::select([
            DB::raw("'c' as type"),
            DB::raw("'change' as requesttype"),
            'quartertype',
            'request_date',
            DB::raw("(CASE
                WHEN is_accepted='0' THEN 'NO'
                ELSE 'YES'
                END) AS is_accepted"),
            'inward_date',
            DB::raw("wno::integer"),
            'remarks',
            DB::raw("(CASE
                WHEN is_allotted='0' THEN 'NO'
                ELSE 'YES'
                END) AS is_allotted"),
            'inward_no',
            'requestid',
            'rivision_id',
            'is_ddo_varified',
            'ddo_remarks',
            'is_varified',
            'r_wno',
            DB::raw("null as is_withdraw"),
    DB::raw("null as withdraw_remarks"),

        ])
            ->where('is_allotted', '=', 0)
            ->where('uid', '=', $uid)
            ->whereNotNull('request_date');
            //->where('quartertype', '=', ($quarterselect[0]->quartertype));
        $quarterlist2 = Tquarterrequestb::select([
            DB::raw("'b' as type"),
            DB::raw("'Higher Category' as requesttype"),
            'quartertype',
            'request_date',
            DB::raw("(CASE
                WHEN is_accepted='0' THEN 'NO'
                ELSE 'YES'
                END) AS is_accepted"),
            'inward_date',
            'wno',
            'remarks',
            DB::raw("(CASE
                WHEN is_allotted='0' THEN 'NO'
                ELSE 'YES'
                END) AS is_allotted"),
            'inward_no',
            'requestid',
            'rivision_id',
            'is_ddo_varified',
            'ddo_remarks',
            'is_varified',
            'r_wno',
             'is_withdraw',
            'withdraw_remarks',
        ])
            //->where('quartertype', '=', ($quarterselect[0]->quartertype))
            ->where('is_allotted', '=', 0)
            ->whereNotNull('request_date')
            ->where('uid', '=', $uid);
        //  ->union($quarterlist)
        // ->get();
        $quarterlist3 = Tquarterrequesta::select([
            DB::raw("'a' as type"),
            DB::raw("'New' as requesttype"),
            'quartertype',
            'request_date',
            DB::raw("(CASE
            WHEN is_accepted='0' THEN 'NO'
            ELSE 'YES'
            END) AS is_accepted"),
            'inward_date',
            'wno',
            'remarks',
            DB::raw("(CASE
                WHEN is_allotted='0' THEN 'NO'
                ELSE 'YES'
                END) AS is_allotted"),
            'inward_no',
            'requestid',
            'rivision_id',
            'is_ddo_varified',
            'ddo_remarks',
            'is_varified',
            'r_wno',
             'is_withdraw',
            'withdraw_remarks',
        ])
          //  ->where('quartertype', '=', ($quarterselect[0]->quartertype))
            ->where('is_allotted', '=', 0)
            ->whereNotNull('request_date')
            ->where('uid', '=', $uid)
            ->union($quarterlist)
            ->union($quarterlist2)
            ->get();



        // Get the logged queries
        //$queries = DB::getQueryLog();

        //dd($queries);
        // You can also log them to Laravel's log file
        //\// Log::info($queries);
        // dd($quarterlist3);
        return Datatables::of($quarterlist3)
            ->addIndexColumn()
            ->addColumn('inward_no', function ($row) {
                if ($row->inward_no == '') return 'N/A';

                return $row->inward_no;
            })
            ->addColumn('inward_date', function ($inward_date) {
                if ($inward_date->inward_date == '')  return 'N/A';
                $inward_date = Carbon::parse($inward_date->inward_date);
                return $inward_date->format('d-m-Y H:i:s');
            })
            ->addColumn('request_date', function ($request_date) {
                if ($request_date->request_date == '')  return 'N/A';
                $request_date = Carbon::parse($request_date->request_date);
                return $request_date->format('d-m-Y');;
            })
            ->addColumn('issues', function ($row) {

                $btn2 = '';
                if ($row->is_accepted == 'YES') {
                    if ($row->remarks == "" && $row->is_varified == 1) {
                        $btn2 = "Verified";
                    } else if ($row->remarks == "" && $row->is_varified == 0) {
                        $btn2 = "Not Verified By Department";
                    } else {
                        $btn2 = '<button type="button" data-uid="' . base64_encode($row->uid) . '" data-rivision_id="' . base64_encode($row->rivision_id) . '"data-type="' . base64_encode($row->type) . '"  data-requestid="' . base64_encode($row->requestid) . '"  data-remarks="' . base64_encode($row->remarks) . '" data-toggle="modal"  class=" btn-view-custom getdocument" > View Remarks</button>';
                    }
                }

                return  $btn2;
            })
            ->addColumn('action', function ($row) {
                /* return   $btn1 = '<a href="' . route('generate.pdf', [
                                'request_id' => base64_encode($row->requestid),
                                'revision_id' => base64_encode($row->revision_id),
                                'performa' => base64_encode($row->type),
                            ]) . '" class="btn btn-primary btn-sm"><i class="fa fa-print"></i></a>';*/

                // Create the print button
                $btn1 = '<a href="' . route('generate.pdf', [
                    'request_id' => base64_encode($row->requestid),
                    'revision_id' => base64_encode($row->rivision_id),
                    'performa' => base64_encode($row->type),
                ]) . '" class="btn btn-primary btn-sm" target="_blank">
        <i class="fa fa-print"></i>
    </a>' . "&nbsp;";

                // Conditional check for the upload button
                //  if ($row->inward_no == '' &&  $row->is_ddo_varified==2) { // Replace with your own condition
                /* if (($row->inward_no == '' &&  $row->is_ddo_varified == 0) || ($row->inward_no != '' &&  $row->is_ddo_varified == 2) || ($row->inward_no != '' &&  $row->is_varified == 2)) {*/
                $btn1 .= '<a href="' . \URL::action('QuartersController@uploaddocument') .
                    "?r=" . base64_encode($row->requestid) .
                    "&type=" . base64_encode($row->type) .
                    "&rev=" . base64_encode($row->rivision_id) .
                    '" class="btn btn-primary btn-sm">
                <i class="fa fa-upload" aria-hidden="true" alt="Upload Documents"></i>
            </a>';



                /* } */

                // Return the generated buttons
                return $btn1;
            })
           ->addColumn('user_remarks', function ($row) {
    $isAccepted = strtoupper((string) $row->is_accepted);

    if (in_array($isAccepted, ['1', 'YES'])) {
        if (!empty($row->is_withdraw)) {
            return '<strong>Withdraw Remarks:</strong> ' . htmlspecialchars($row->withdraw_remarks);
        }

        if (!empty($row->wno)) {
        return '<button type="button"
            class="btn btn-sm btn-warning office_popup charcher_data"
            data-requestid="' . base64_encode($row->requestid) . '"
            data-requesttype="' . $row->requesttype . '"
            data-wno="' . $row->wno . '"
            data-quartertype="' . $row->quartertype . '">
            Withdraw Application
            </button>';


        }
    }

    return ''; // nothing to show
})           
->rawColumns(['action','issues','user_remarks'])

            ->make(true);
    }
    public function generate_pdf($request_id, $revision_id, $performa)
    {
        $uid = Session::get('Uid');
        $requestid = base64_decode($request_id);
        $type = base64_decode($performa);
        $rivision_id = base64_decode($revision_id);

        // Model decide karo based on type
        if ($type === 'a') {
            $requestModel = new Tquarterrequesta();
        } else if ($type === 'b') {
            $requestModel = new Tquarterrequestb();
        }

        // Call service here
        $pdfService = app(\App\Services\PdfGeneratorService::class);
        $pdfService->generate($requestModel, $requestid, $rivision_id, $type, 'I');
    }

    public function saveuploaddocument(request $request)
    {
        // dd($request->all());
        $docId = (string)Session::get('Uid') . "_" . base64_decode($request->request_id) . "_" . $request->document_type . "_" . base64_decode($request->perfoma) . "_" . base64_decode($request->request_rev);
        //dd($docId,$request->file('image'));
        uploadDocuments($docId, $request->file('image'));
        return redirect()->back()->with(['updated' => 1]);
    }
    public function deletedoc(Request $request)
    // public function deletedoc($rid,$id)
    {
        // Initialize CouchDB connection
        $extended = new Couchdb(URL_COUCHDB, USERNAMECD, PASSWORDCD);
        $extended->InitConnection();

        try {
            // Get document details from CouchDB
            $doc = $extended->getDocument(DATABASE, $request->id);
            $documentData = json_decode($doc, true);
            //\// Log::debug('Raw Document Response: ' . $doc);
            // Access specific fields from the document data
            $id = $documentData['_id'];
            $rev = $documentData['_rev'];
            //echo $id;
            // Delete the document from CouchDB
            $extended->deleteDocument(DATABASE, $id, $rev);

            // Delete the corresponding record from the master.Filelist table
            DB::table('master.file_list')->where('doc_id', '=', $request->id)->delete();

            // Return success response
            return response()->json(['success' => true, 'message' => 'Document deleted successfully.']);
        } catch (Exception $e) {
            // Return failure response
            return response()->json(['success' => false, 'message' => "ERROR: " . $e->getMessage() . " (" . $e->getCode() . ")"]);
        }
    }
    public function showDocument(Request $request)
    {
        $doc_id = $request->doc_id;

        $extended = new Couchdb(URL_COUCHDB, USERNAMECD, PASSWORDCD);
        $extended->InitConnection();
        $status = $extended->isRunning();

        $getDocument = $extended->getDocument(DATABASE, $doc_id);
        //   dd($getDocument);
        $couchDbResponse = json_decode($getDocument, true);

        if (isset($couchDbResponse['_attachments'])) {
            $attachments = $couchDbResponse['_attachments'];
        } else {
            return "Document Not Found!";
        }

        foreach ($attachments as $key => $value) {
            $getFileContent = file_get_contents(COUCHDB_DOWNLOADURL . "/" . DATABASE . "/" . $doc_id . "/" . $key . "");
            $headers = ['Content-type' => $value['content_type']];

            if ($getFileContent) {
                // Generate a unique window name
                $windowName = 'document_window_' . uniqid();

                // JavaScript to open a new window with black background and show the document
                $js = "
                var win = window.open('', '$windowName', 'width=800,height=600');
                win.document.body.style.backgroundColor = 'black';
                win.document.write('<embed width=\"100%\" height=\"100%\" src=\"data:$value[content_type];base64," . base64_encode($getFileContent) . "\">');
            ";

                // Return the JavaScript to the client
                //return response()->javascript($js);
                // Return the base64 encoded content
                return response()->json([
                    'document_url' => base64_encode($getFileContent),
                    'contentType' => 'application/pdf',

                    'status' => 'success',
                ]);
            } else {
                return "Error fetching the document";
            }
        }
    }
    public function quarterlistnormal()
    {
        $this->_viewContent['page_title'] = "Quarter Request (Normal)";
        return view('request/quarterlistnormal', $this->_viewContent);
    }

    public function quarterNewRequest()
    {
        $this->_viewContent['page_title'] = "Quarter Request Details";
        return view('request/newQuarterRequest', $this->_viewContent);
    }

    public function editquarter_a(request $request, $requestid, $rivision_id, $uid)
    {

        $requestid = base64_decode($requestid);
        $rivision_id = base64_decode($rivision_id);
        $uid = base64_decode($uid);
        //  dd($uid);
        $requestModel = new Tquarterrequesta();
        $quarterrequest = $requestModel->getFormattedRequestData($requestid, $rivision_id);


        $this->_viewContent['file_uploaded'] = Filelist::select(['document_id', 'rev_id', 'doc_id', 'document_name', 'is_file_admin_verified'])
            ->join('master.m_document_type as  d', 'd.document_type', '=', 'master.file_list.document_id')
            ->where('request_id', '=', $requestid)
            ->where('rivision_id', '=', $rivision_id)
            ->where('uid', '=', $uid)
            ->where('master.file_list.performa', '=', 'a')
            ->get();
        //dd( $this->_viewContent['file_uploaded']);

        $this->_viewContent['quarterrequest1'] = Tquarterrequesta::select([
            'request_date',
            'requestid',
            'quartertype',
            'inward_no',
            'inward_date',
            'rivision_id',
            'remarks',
            'is_accepted',
            'is_allotted',
            'is_varified'
        ])
            ->where('requestid', '=', $requestid)
            ->where('uid', '=', $quarterrequest['uid'])
            ->get();

        $this->_viewContent['quarterrequest'] = (isset($quarterrequest) && isset($quarterrequest)) ? $quarterrequest : '';
        $this->_viewContent['page_title'] = "Quarter Edit Details";
        return view('request/updatequarterrequest', $this->_viewContent);
    }
    public function editquarter_b(request $request, $requestid, $rivision_id, $uid)
    {
        // dd($requestid, $rv);
        $requestid = base64_decode($requestid);
        $rivision_id = base64_decode($rivision_id);
        $uid = base64_decode($uid);
        $requestModel = new Tquarterrequestb();
        $quarterrequest = $requestModel->getFormattedRequestData($requestid, $rivision_id);


        $this->_viewContent['file_uploaded'] = Filelist::select(['document_id', 'rev_id', 'doc_id', 'document_name', 'is_file_admin_verified'])
            ->join('master.m_document_type as  d', 'd.document_type', '=', 'master.file_list.document_id')
            ->where('request_id', '=', $requestid)
            ->where('rivision_id', '=', $rivision_id)
            ->where('uid', '=', $uid)
            ->where('master.file_list.performa', '=', 'b')
            ->get();


        $this->_viewContent['quarterrequest1'] = Tquarterrequestb::select([
            'request_date',
            'requestid',
            'quartertype',
            'inward_no',
            'inward_date',
            'rivision_id',
            'remarks',
            'is_accepted',
            'is_allotted',
            'is_varified'
        ])
            ->where('requestid', '=', $requestid)
            ->where('uid', '=', $quarterrequest['uid'])
            ->get();

        $this->_viewContent['quarterrequest'] = (isset($quarterrequest) && isset($quarterrequest)) ? $quarterrequest : '';
        $this->_viewContent['page_title'] = "Quarter Edit Details";
        return view('request/updatequarterrequest_b', $this->_viewContent);
    }
    public function downloaddocument(request $request)
    {
        $url_segment = \Request::segment(2);
        // dd($url_segment);
        $extended = new Couchdb(URL_COUCHDB, USERNAMECD, PASSWORDCD);
        try {
            // Initialize the connection
            $extended->InitConnection();

            // Check if the connection is running
            $status = $extended->isRunning();

            if (!$status) {
                throw new \Exception("Connection is not running");
            }

            // Sanitize the URL segment
            $downloaf = htmlentities(strip_tags($url_segment), ENT_QUOTES);
            // dd($downloaf);
            // Attempt to retrieve the document
            $response = $extended->getDocument(DATABASE, $downloaf);
            // dd($response);
            // Check if the response contains an error
            if (isset($response['error']) && $response['error'] === 'not_found') {
                throw new \Exception("Document not found: " . $downloaf);
            }


            $result1 = json_decode($response, true);
            if (!empty($result1)) {
                //$result1 = json_encode($result1, true);

                if (isset($result1['_attachments']) && !empty($result1['_attachments'])) {
                    $data = $result1['_attachments'];

                    foreach ($data as $key => $value) {
                        $cont = file_get_contents(COUCHDB_DOWNLOADURL . "/" . DATABASE . "/" . $downloaf . "/" . $key);

                        return Response::make($cont, 200, [
                            'Content-Disposition' => 'attachment; filename="' . $key . '"',
                            'Content-Type' => $value['content_type'],
                        ]);
                    }
                } else {
                    // throw new \Exception("No attachments found in the document: " . $downloaf);
                    return Redirect::back()->withErrors(['No attachments found in the document:' => $downloaf]);
                }
            } else {
                return Redirect::back()->withErrors(['No attachments found in the document:' => $downloaf]);
            }
        } catch (\Exception $e) {
            // Handle exceptions and output the error message
            return Response::make("An error occurred: " . $e->getMessage(), 500);
        }
    }
    public function saveapplication(request $request)
    {

        $officecode = Session::get('officecode');

        $status = $request->status;
        // dd($request);
        $requestid = $request->requestid;
        $dg_allotment = $request->dg_allotment;
        $rv = $request->rv;
        $dg_request_id = Tquarterrequesta::where('officecode', '=', $officecode)->orderBy('requestid', 'DESC')->value('requestid');

        //dd($dg_request_id );
        $dg_request_id += 1;



        //get data using request and revision id
        $result = Tquarterrequesta::where('requestid', $requestid)
            ->where('rivision_id', $rv)
            ->where('officecode', '=', $officecode)
            ->first();


        $filetable = Filelist::where('uid', $result->uid)->get(); // Get all files for the user
        $files = $request->input('files'); // Get files from the form (array of doc_id => 'on' or 'off')
        //dd($files);
        // dd($filetable);
        foreach ($filetable as $file) {
            //dd($file->doc_id);
            // Check if the doc_id exists in the $files array
            if (isset($files[$file->doc_id])) {
                //dd("hello");
                // If the checkbox for this file was checked
                if ($files[$file->doc_id] === 'on') {
                    //  dd("on");
                    // Update the file to 'checked'
                    Filelist::where('doc_id', $file->doc_id)
                        ->update(['is_file_admin_verified' => 1]); // Update      
                }
            } else {
                Filelist::where('doc_id', $file->doc_id)
                    ->update(['is_file_admin_verified' => 2]); // Update directly
            }
        }

        //  dd( $result);
        //dd($status);
        //  dd($request->submit_issue);
        //if ($status != 0) {
        if ($request->submit_issue == null) {
            // dd("submit");
            try {

                $quarterTypeInstance = new QuarterType();
                $wno = $quarterTypeInstance->getNextWno($result->quartertype, $officecode);
                // echo $wno; exit;
                //dd($wno);

                // Retrieve r_wno value
                // $rWnoA = Tquarterrequesta::getMaxRwno($result->quartertype, $officecode);
                // $rWnoB = Tquarterrequesta::getMaxRwno($result->quartertype, $officecode);
                $rWnoA = $quarterTypeInstance->getNextRwno($result->quartertype, $officecode);
                //    $rWnoB = $quarterTypeInstance->getMaxRwno($result->quartertype, $officecode);
                //  $rWno = max($rWnoA, $rWnoB) + 1;
                $rWno = $rWnoA;
                //dd($rWno);
                // Update the TQuarterRequestA record
                $t_quarterrequest_a = Tquarterrequesta::where('requestid', $requestid)
                    ->where('rivision_id', $rv)->where('uid', $result->uid)->first();
                // dd($t_quarterrequest_a);
                //dd(auth()->user()->id);
                if ($t_quarterrequest_a) {
                    // Store the current customer details in history before updating
                    $t_quarterrequest_a_Data = $t_quarterrequest_a->toArray();
                    $t_quarterrequest_a_Data['created_by'] = auth()->user()->id;  // User's ID for created_by
                    $t_quarterrequest_a_Data['updated_by'] = auth()->user()->id;  // User's ID for updated_by
                    $t_quarterrequest_a_Data['created_at'] = now();  // Current timestamp for created_at
                    $t_quarterrequest_a_Data['updated_at'] = now();  // Current timestamp for updated_at

                    //dd($request->get('conn_status'));
                    // Insert data into the history table
                    Tquarterequesthistorya::create($t_quarterrequest_a_Data);
                    $requestModel = new Tquarterrequesta();
                    $pdfContent = app(\App\Services\PdfGeneratorService::class)->generate(
                        $requestModel,
                        $requestid,
                        $rv,
                        'a',
                        'S'  // <-- return as string
                    );
                    if (empty($pdfContent)) {
                        dd("PDF generation failed or returned empty content");
                    }
                    $tempPdfPath = storage_path('app/temp_' . uniqid() . '.pdf');
                    file_put_contents($tempPdfPath, $pdfContent);

                    // Convert it to UploadedFile instance
                    $tempUploadedFile = new UploadedFile(
                        $tempPdfPath,
                        'form.pdf',
                        'application/pdf',
                        null,
                        true // $test = true allows non-uploaded files
                    );
                    $docId = (string)$result->uid . "_" . $requestid . "_" . 6 . "_a_" . $rv;
                    //  dd( $docId);
                    uploadDocuments($docId, $tempUploadedFile, $result->uid);
                    $storagePath = public_path("pdfs/{$result->uid}/");
                    $fileName = $result->uid . '_applicationform.pdf';
                    $fullFilePath = $storagePath . $fileName;
                    if (file_exists($fullFilePath)) {
                        @unlink($fullFilePath);
                    }
                    if (is_dir($storagePath) && count(scandir($storagePath)) <= 2) {
                        @rmdir($storagePath);
                    }
                }
                Tquarterrequesta::where('requestid', $requestid)
                    ->where('rivision_id', $rv)
                    ->update([
                        'remarks' => '',
                        'is_varified' => $status,
                        'is_accepted' => 1,
                        'wno' => $wno,
                        'r_wno' => $rWno,
                        'updatedby' => Session::get('Uid')
                    ]);
                // Update the User record
                $userRecord = User::where('id', $result->uid)
                    ->where('is_police_staff', 'Y')
                    ->first();
                // Update the PoliceStaffVerify column for the fetched record
                if ($userRecord) {
                    $userRecord->update(['PoliceStaffVerify' => 2]);
                }

                // Email sending part
                //$msg = "Request with inward no : $inward_no has been Accepted successfully. Kindly check Awas Allot Portal";
                //$subject = "Awas Allot Portal";
                //SendMail::send_mail($email, $msg, $subject, $uid1);
            } catch (\Exception $e) {
                // Handle any exceptions here
                // Log the error, display a message, or take any necessary actions
                dd($e->getMessage()); // For debugging purposes, you can dump the error message
            }

            if ($dg_allotment == 'Y') { // dd("hi",$dg_allotment);
                try {
                    // Fetch the next quartertype directly in a single query
                    $quartertype = $result->quartertype;
                    $dgQuartertype = QuarterType::select('quartertype')
                        ->where('priority', function ($query) use ($quartertype) {
                            $query->selectRaw('priority + 1')
                                ->from('master.m_quarter_type')
                                ->where('quartertype', $quartertype);
                        })
                        ->first();
                    // dd($dgQuartertype->quartertype);
                    $quarterTypeInstance = new QuarterType();
                    $dg_wno = $quarterTypeInstance->calculateDgWno($dgQuartertype->quartertype, $officecode);
                    //  dd($dg_wno);
                    // Create and save a new Tquarterrequesta instance
                    // Enable query logging
                    //DB::enableQueryLog();

                    // Create the record
                    $requestModel = Tquarterrequesta::create([
                        'uid' => $result->uid,
                        'requestid' => $dg_request_id,
                        'quartertype' => $dgQuartertype->quartertype,
                        'inward_no' => $result->inward_no,
                        'old_designation' => $result->old_designation,
                        'old_office' => $result->old_office,
                        'deputation_date' => $result->deputation_date,
                        'prv_area_name' => $result->prv_area_name,
                        'prv_building_no' => $result->prv_building_no,
                        'prv_quarter_type' => $result->prv_quarter_type,
                        'prv_rent' => $result->prv_rent,
                        'prv_handover' => $result->prv_handover,
                        'have_old_quarter' => $result->have_old_quarter,
                        'old_quarter_details' => $result->old_quarter_details,
                        'is_scst' => $result->is_scst,
                        'scst_info' => $result->scst_info,
                        'is_relative' => $result->is_relative,
                        'relative_details' => $result->relative_details,
                        'is_relative_householder' => $result->is_relative_householder,
                        'relative_house_details' => $result->relative_house_details,
                        'have_house_nearby' => $result->have_house_nearby,
                        'nearby_house_details' => $result->nearby_house_details,
                        'downgrade_allotment' => 'N',
                        'request_date' => now(),
                        'is_downgrade_request' => 1,
                        'is_priority' => 'N',
                        'reference_id' => $result->requestid,
                        'dg_rivision_id' => $result->rivision_id,
                        'is_varified' => 1,
                        'is_accepted' => 1,
                        'remarks' => '',
                        'updatedBy' => $result->uid,
                        'is_ddo_varified' => 1,
                        'cardex_no' => $result->cardex_no,
                        'ddo_code' => $result->ddo_code,
                        'wno' => $dg_wno,
                        'officecode' => $result->officecode,



                    ]);

                    // Get the last executed query
                    //$query = DB::getQueryLog();
                    //dd(end($query));
                    // Update Dgrid in TQuarterRequestA
                    Tquarterrequesta::where('requestid', $requestid)
                        ->where('rivision_id', $rv)
                        ->update(['dgrid' => $dg_request_id]);

                    // Retrieve max r_wno
                    $maxRwno = DB::table('master.t_quarter_request_a')
                        ->select(DB::raw('MAX(r_wno) AS r_wno'))
                        ->where('is_priority', 'N')
                        ->where('quartertype', $dgQuartertype->quartertype)
                        ->whereNotNull('wno')
                        ->union(function ($query) use ($dgQuartertype) {
                            $query->select(DB::raw('MAX(r_wno) AS r_wno'))
                                ->from('master.t_quarter_request_b')
                                ->where('is_priority', 'N')
                                ->where('quartertype', $dgQuartertype->quartertype)
                                ->whereNotNull('wno');
                        })
                        ->max('r_wno');

                    $rWno1 = $maxRwno + 1;
                    // dd($rWno1);
                    // Update r_wno in TQuarterRequestA
                    DB::table('master.t_quarter_request_a')
                        ->where('quartertype', $dgQuartertype->quartertype)
                        ->where('requestid', $dg_request_id)
                        ->where('wno',  $dg_wno)
                        ->update(['r_wno' => $rWno1]);
                } catch (Exception $ex) {
                    $conn->rollBack();
                    //  $errorMessage = "Propel Exception Occurred. Please try again.";
                    //  header("Location:masterpage.php?pagename=" . base64_encode("request/requestprocess_a.php") . "&r=" . base64_encode($requestid) . "&rv=" . base64_encode($rivision_id) . "&emsg=" . base64_encode($errorMessage));
                    exit;
                }
            }
            // $msg = "Request with inward no : $inward_no has been Accepted successfully. Kindly check Awas Allot Portal";
            //	$subject = "Awas Allot Portal";
            //	SendMail::send_mail($email,$msg ,$subject,$uid1);
            //  $conn->commit();
            //  Master::notify('S',"Request with inward no : $inward_no has been Accepted successfully. Kindly check <a href='front.php?pagename=".base64_encode("front_links.php")."'>Quarter Request</a> section for further details",$req_uid);
            return redirect('/quarterlistnormal')->with('success', 'Request Verified Successfully!');
        } else {
            //dd("have issue");
            $status = 2;

            //  dd($request->adm_remarks,$request->admin_remarks);
            $result = Tquarterrequesta::where('requestid', $requestid)->where('rivision_id', $rv)
                ->update(['is_varified' => $status, 'is_accepted' => 1, 'updatedby' => session::get('Uid')]);
            if ($result) {
                $this->_viewContent['requestid'] = $requestid;
                $this->_viewContent['rv'] = $rv;
                $this->_viewContent['type'] = 'a';
                $remarks = Tquarterrequesta::select('remarks')->where('requestid', $requestid)->where('rivision_id', $rv)->first();
                //dd($remarks);
                // $remarks = Remarks::get();
                //  dd($remarks);
                $this->_viewContent['remarks'] =  $remarks;
                $this->_viewContent['page_title'] = "Remarks";
                return view('request/remarks', $this->_viewContent);
            } else {

                return redirect()->route('editquarter_a', ['r' => $requestid, 'rv' => $rv, 'uid' => $userRecord->id])->with('success', 'There is some problem in processing request please try again later!');
            }
        }
    }



    public function saveapplication_b(request $request)
    {
        $officecode = Session::get('officecode');
        $status = $request->status;
        $requestid = $request->requestid;

        $dg_allotment = $request->dg_allotment;
        $rv = $request->rv;
        $dg_request_id = Tquarterrequestb::orderBy('requestid', 'DESC')->value('requestid');
        $dg_request_id += 1;
        // dd($request->submit_issue);

        //get data using request and revision id
        $result = Tquarterrequestb::where('requestid', $requestid)
            ->where('rivision_id', $rv)
            ->first();
        //echo "<pre>";  print_r( $result);
        $filetable = Filelist::where('uid', $result->uid)->get(); // Get all files for the user
        $files = $request->input('files'); // Get files from the form (array of doc_id => 'on' or 'off')
        //dd($files);
        // dd($filetable);
        foreach ($filetable as $file) {
            //dd($file->doc_id);
            // Check if the doc_id exists in the $files array
            if (isset($files[$file->doc_id])) {
                //dd("hello");
                // If the checkbox for this file was checked
                if ($files[$file->doc_id] === 'on') {
                    //  dd("on");
                    // Update the file to 'checked'
                    Filelist::where('doc_id', $file->doc_id)
                        ->update(['is_file_admin_verified' => 1]); // Update      
                }
            } else {
                Filelist::where('doc_id', $file->doc_id)
                    ->update(['is_file_admin_verified' => 2]); // Update directly
            }
        }

        if ($request->submit_issue == null) {
            try {

                $quarterTypeInstance = new QuarterType();
                $wno = $quarterTypeInstance->getNextWno($result->quartertype, $officecode);
                // echo $wno; exit;
                // dd($wno);

                // Retrieve r_wno value
                // $rWnoA = Tquarterrequesta::getMaxRwno($result->quartertype);
                // $rWnoB = Tquarterrequestb::getMaxRwno($result->quartertype);
                $rWnoA = $quarterTypeInstance->getNextRWno($result->quartertype, $officecode);
                //$rWnoB = $quarterTypeInstance->getNextRWno($result->quartertype, $officecode);
                //$rWno = max($rWnoA, $rWnoB) + 1;
                $rWno = $rWnoA;
                //dd($rWnoA,$rWno);
                // Update the TQuarterRequestB record
                $t_quarterrequest_b = Tquarterrequestb::where('requestid', $requestid)
                    ->where('rivision_id', $rv)->where('uid', $result->uid)->first();
                // dd($t_quarterrequest_b);
                //dd(auth()->user()->id);
                if ($t_quarterrequest_b) {

                    $t_quarterrequest_b_Data = $t_quarterrequest_b->toArray();

                    $t_quarterrequest_b_Data['created_by'] = auth()->user()->id; // User's ID for created_by
                    $t_quarterrequest_b_Data['updated_by'] = auth()->user()->id; // User's ID for updated_by
                    $t_quarterrequest_b_Data['created_at'] = now(); // Current timestamp for created_at
                    $t_quarterrequest_b_Data['updated_at'] = now(); // Current timestamp for updated_at
                    // Insert data into the history table
                    Tquarterrequesthistoryb::create($t_quarterrequest_b_Data);
                    // $requestModel = new Tquarterrequestb();

                    $requestModel = new Tquarterrequestb();

                    $pdfContent = app(\App\Services\PdfGeneratorService::class)->generate(
                        $requestModel,
                        $requestid,
                        $rv,
                        'b',
                        'S'  // <-- return as string
                    );
                    if (empty($pdfContent)) {
                        dd("PDF generation failed or returned empty content");
                    }
                    $tempPdfPath = storage_path('app/temp_' . uniqid() . '.pdf');
                    file_put_contents($tempPdfPath, $pdfContent);

                    // Convert it to UploadedFile instance
                    $tempUploadedFile = new UploadedFile(
                        $tempPdfPath,
                        'form.pdf',
                        'application/pdf',
                        null,
                        true // $test = true allows non-uploaded files
                    );
                    $docId = (string)$result->uid . "_" . $requestid . "_" . 6 . "_b_" . $rv;
                    // $docId = (string)Session::get('Uid') . "_" . base64_decode($request->request_id) . "_" . $request->document_type . "_" . base64_decode($request->perfoma) . "_" . base64_decode($rv);
                    //  dd($docId );
                    uploadDocuments($docId, $tempUploadedFile, $result->uid);
                    $storagePath = public_path("pdfs/{$result->uid}/");
                    $fileName = $result->uid . '_applicationform.pdf';
                    $fullFilePath = $storagePath . $fileName;

                    if (file_exists($fullFilePath)) {
                        @unlink($fullFilePath);
                    }


                    if (is_dir($storagePath) && count(scandir($storagePath)) <= 2) {
                        @rmdir($storagePath);
                    }
                }

                // Update the TQuarterRequestB record
                Tquarterrequestb::where('requestid', $requestid)
                    ->where('rivision_id', $rv)
                    ->update([
                        'remarks' => '',
                        'is_varified' => $status,
                        'is_accepted' => 1,
                        'wno' => $wno,
                        'r_wno' => $rWno,
                        'updatedby' => Session::get('Uid')
                    ]);
                // Update the User record
                $userRecord = User::where('id', $result->uid)
                    ->where('is_police_staff', 'Y')
                    ->first();
                // Update the PoliceStaffVerify column for the fetched record
                if ($userRecord) {
                    $userRecord->update(['PoliceStaffVerify' => 2]);
                }

                // Email sending part
                //$msg = "Request with inward no : $inward_no has been Accepted successfully. Kindly check Awas Allot Portal";
                //$subject = "Awas Allot Portal";
                //SendMail::send_mail($email, $msg, $subject, $uid1);
            } catch (\Exception $e) {
                // Handle any exceptions here
                // Log the error, display a message, or take any necessary actions
                dd($e->getMessage()); // For debugging purposes, you can dump the error message
            }



            // $msg = "Request with inward no : $inward_no has been Accepted successfully. Kindly check Awas Allot Portal";
            //	$subject = "Awas Allot Portal";
            //	SendMail::send_mail($email,$msg ,$subject,$uid1);
            //  $conn->commit();
            //  Master::notify('S',"Request with inward no : $inward_no has been Accepted successfully. Kindly check <a href='front.php?pagename=".base64_encode("front_links.php")."'>Quarter Request</a> section for further details",$req_uid);
            return redirect('/quarterlistnormal')->with('success', 'Request Verified Successfully!');
        } else {
            $status = 2;

            $result = Tquarterrequestb::where('requestid', $requestid)->where('rivision_id', $rv)
                ->update(['is_varified' => $status, 'is_accepted' => 1, 'updatedby' => session::get('Uid')]);
            if ($result) {
                //dd($requestid,$rv);

                $this->_viewContent['requestid'] = $requestid;
                $this->_viewContent['rv'] = $rv;
                $this->_viewContent['type'] = 'b';
                //$remarks = Remarks::get();
                $remarks = Tquarterrequestb::select('remarks')->where('requestid', $requestid)->where('rivision_id', $rv)->first();
                // dd($remarks);
                $this->_viewContent['remarks'] =  $remarks;
                $this->_viewContent['page_title'] = "Remarks";
                return view('request/remarks', $this->_viewContent);
            } else {

                return redirect()->route('editquarter_b', ['r' => $requestid, 'rv' => $rv])->with('success', 'There is some problem in processing request please try again later!');
            }
        }
    }
    public function saveremarks(request $request)
    {
        //   dd($request->all());
        $requestid = base64_decode($request->r);
        $rv = base64_decode($request->rv);
        $type = base64_decode($request->type);
        $page_title = "Remarks";
        $remarks = ($request->input('remarks'));
        // dd($remarks);
        // Manual validation
        if (is_null($remarks) || trim($remarks) === '' || $remarks === '{"remarks":null}') {
            session()->flash('failed', 'Please select at least one remark.');
            return view('request/remarks', [
                'requestid' => $requestid,
                'rv' => $rv,
                'type' => $type,
                'remarks' => $remarks,
                'page_title' => 'Remarks',

            ]);
        }
        $remarks = trim($remarks, '"'); // Remove trailing quote
        //    dd($remarks);
        $remarksArray = explode(',', $remarks);
        //    dd($remarksArray);
        $remarksArray = array_map('intval', $remarksArray);
        // dd($remarksArray);
        if ($type == 'a') {

            $t_quarterrequest_a = Tquarterrequesta::where('requestid', $requestid)
                ->where('rivision_id', $rv)->first();
            // dd($t_quarterrequest_a);
            //dd(auth()->user()->id);
            if ($t_quarterrequest_a) {
                // Store the current customer details in history before updating
                $t_quarterrequest_a_Data = $t_quarterrequest_a->toArray();
                //dd($t_quarterrequest_a_Data);
                $t_quarterrequest_a_Data['created_by'] = auth()->user()->id;  // User's ID for created_by
                $t_quarterrequest_a_Data['updated_by'] = auth()->user()->id;  // User's ID for updated_by
                $t_quarterrequest_a_Data['created_at'] = now();  // Current timestamp for created_at
                $t_quarterrequest_a_Data['updated_at'] = now();  // Current timestamp for updated_at

                //dd($request->get('conn_status'));
                // Insert data into the history table

                Tquarterequesthistorya::create($t_quarterrequest_a_Data);
            }

            $result = Tquarterrequesta::where('requestid', $requestid)->where('rivision_id', $rv)
                ->update(['remarks' => $remarks, 'remarks_date' => date('Y-m-d')]);
            return redirect('/quarterlistnormal')->with('success', 'Remarks added successfully!');
        }
        if ($type == 'b') {
            $result = Tquarterrequestb::where('requestid', $requestid)->where('rivision_id', $rv)
                ->update(['remarks' => $remarks, 'remarks_date' => date('Y-m-d')]);
            return redirect('/quarterlistnormal')->with('success', 'Remarks added successfully!');
        }
    }
    public function viewApplication(request $request, $requestid, $rivision_id, $performa)
    {
        if ($performa == 'a') {
            $req_uid = Tquarterrequesta::where('requestid', $requestid)
                ->select('uid')
                ->first();

            $request = Tquarterrequesta::with(['usermaster' => function ($query) {
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
                    'remarks'
                ]);
            }])
                ->select([
                    'wno',
                    'quartertype',
                    'uid',
                    'old_office',
                    'old_designation',
                    'deputation_date',
                    'prv_area_name',
                    'prv_building_no',
                    'prv_quarter_type',
                    'prv_rent',
                    'prv_handover',
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
                    'request_date',
                    'inward_no',
                    'inward_date',
                    'is_varified',
                    'requestid',
                    'rivision_id',
                    'dgrid'
                ])
                ->where('requestid', $requestid)
                ->where('rivision_id', $rivision_id)
                ->first();
            $this->_viewContent['quarterrequest1'] = Tquarterrequesta::select([
                'request_date',
                'requestid',
                'quartertype',
                'inward_no',
                'inward_date',
                'rivision_id',
                'remarks',
                'is_accepted',
                'is_allotted',
                'is_varified'
            ])
                ->where('requestid', '=', $requestid)
                ->where('uid', '=', $request->uid)
                ->get();
        } else {
            $req_uid = Tquarterrequestb::where('requestid', $requestid)
                ->select('uid')
                ->first();
            $request = Tquarterrequestb::with(['usermaster' => function ($query) {
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
                    'remarks'
                ]);
            }])
                ->select([
                    'wno',
                    'quartertype',
                    'uid',
                    'old_office',
                    'old_designation',
                    'deputation_date',
                    'prv_area_name',
                    'prv_building_no',
                    'prv_quarter_type',
                    'prv_rent',
                    'prv_handover',
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
                    'request_date',
                    'inward_no',
                    'inward_date',
                    'is_varified',
                    'requestid',
                    'rivision_id',
                    'dgrid'
                ])
                ->where('requestid', $requestid)
                ->where('rivision_id', $rivision_id)
                ->first();
            $this->_viewContent['quarterrequest1'] = Tquarterrequestb::select([
                'request_date',
                'requestid',
                'quartertype',
                'inward_no',
                'inward_date',
                'rivision_id',
                'remarks',
                'is_accepted',
                'is_allotted',
                'is_varified'
            ])
                ->where('requestid', '=', $requestid)
                ->where('uid', '=', $request->uid)
                ->get();
        }
        $this->_viewContent['file_uploaded'] = Filelist::select(['document_id', 'rev_id', 'doc_id', 'document_name'])
            ->join('master.m_document_type as  d', 'd.document_type', '=', 'master.Filelist.document_id')
            ->where('request_id', '=', $requestid)
            ->where('rivision_id', '=', $rivision_id)
            ->where('master.Filelist.performa', '=', $performa)
            ->get();
        $remarks =  Remarks::where('rtype', '1')->get();
        $this->_viewContent['remarks'] = $remarks;
        $this->_viewContent['quarterrequest'] = (isset($request) && isset($request)) ? $request : '';
        $this->_viewContent['page_title'] = " Edit Quarter Details";
        return view('request/viewapplication', $this->_viewContent);
    }

    public function getNormalquarterList(Request $request)
    {
        $officecode = Session::get('officecode');

        $first = Tquarterrequesta::from('master.t_quarter_request_a AS a')->select([
            'request_date',
            DB::raw("'a'::text as type"),
            DB::raw("'New'::text as requesttype"),
            'requestid',
            'quartertype',
            'inward_no',
            'inward_date',
            'u.name',
            'u.designation',
            'office',
            'rivision_id',
            'a.remarks',
            'contact_no',
            'address',
            'gpfnumber',
            'is_accepted',
            'is_allotted',
            'is_varified',
            'email',
            'is_priority',
            'is_ddo_varified',
            'officecode',
            'a.cardex_no',
            'a.ddo_code',
            'u.id as uid'
        ])
            ->join('userschema.users as u', 'u.id', '=', 'a.uid');

        $second = Tquarterrequestc::from('master.t_quarter_request_c AS c')->select([
            'request_date',
            DB::raw("'c' as type"),
            DB::raw("'Change' as requesttype"),
            'requestid',
            'quartertype',
            'inward_no',
            'inward_date',
            'u.name',
            'u.designation',
            'office',
            'rivision_id',
            'c.remarks',
            'contact_no',
            'address',
            'gpfnumber',
            'is_accepted',
            'is_allotted',
            'is_varified',
            'email',
            'is_priority',
            'is_ddo_varified',
            'officecode',
            'c.cardex_no',
            'c.ddo_code',
            'u.id as uid'
        ])
            ->join('userschema.users as u', 'u.id', '=', 'c.uid');

        $union = Tquarterrequestb::from('master.t_quarter_request_b AS b')->select([
            'request_date',
            DB::raw("'b'::text as type"),
            DB::raw("'Higher Category'::text as requesttype"),
            'requestid',
            'quartertype',
            'inward_no',
            'inward_date',
            'u.name',
            'u.designation',
            'office',
            'rivision_id',
            'b.remarks',
            'contact_no',
            'address',
            'gpfnumber',
            'is_accepted',
            'is_allotted',
            'is_varified',
            'email',
            'is_priority',
            'is_ddo_varified',
            'officecode',
            'b.cardex_no',
            'b.ddo_code',
            'u.id as uid'
        ])
            ->join('userschema.users as u', 'u.id', '=', 'b.uid')
            ->union($first)
            ->union($second);

        $query = DB::table(DB::raw("({$union->toSql()}) as x"))
            ->mergeBindings($union->getQuery())
            ->select([
                'type',
                'requesttype',
                'requestid',
                'quartertype',
                'inward_no',
                'inward_date',
                'name',
                'designation',
                'office',
                'rivision_id',
                'remarks',
                'contact_no',
                'address',
                'gpfnumber',
                'is_accepted',
                'is_allotted',
                'is_varified',
                'email',
                'request_date',
                'is_priority',
                'is_ddo_varified',
                'officecode',
                'cardex_no',
                'ddo_code',
                'uid'
            ])
            ->where(function ($query) use ($officecode) {
                $query->where('is_accepted', '=', 1)
                    ->whereNull('remarks')
                    ->where('is_priority', '=', 'N')
                    ->where('is_ddo_varified', '=', 1)
                    ->where('officecode', '=', $officecode)
                    ->where('is_varified', 0);
            })
            ->orderBy('inward_date', 'asc');



        // for showing action button on FCFS request for each quarter type 
        $firstInwardPerQuarterType = DB::table(DB::raw("({$union->toSql()}) as sub"))
            ->mergeBindings($union->getQuery())
            ->select('quartertype', DB::raw('MIN(inward_date) as min_date'))
            ->where('is_accepted', '=', 1)
            ->whereNull('remarks')
            //->where('is_varified', '=', 0)
            ->where('is_priority', '=', 'N')
            ->where('is_ddo_varified', '=', 1)
            ->where('officecode', '=', $officecode)
            ->where('is_varified', 0)
            ->groupBy('quartertype')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->quartertype => $item->min_date];
            });
        //dd($firstInwardPerQuarterType);
        // Print the SQL query
        //  dd( $query->toSql());
        //     dd("hello");

        return Datatables::of($query)
            ->addColumn('inward_date', function ($date) {
                if ($date->inward_date == '')  return 'N/A';

                return date('d-m-Y H:i:s', strtotime($date->inward_date));
            })
            ->addColumn('request_date', function ($date) {
                if ($date->request_date == '')  return 'N/A';

                return date('d-m-Y', strtotime($date->request_date));
            })
            ->addColumn('cardex_ddo', function ($row) {
                return $row->cardex_no . "/" . $row->ddo_code;
            })
            // ->addColumn('action', function ($row) use (&$cnt) {
            //     $cnt++; // increment per row processed
            //     if ($cnt !== 1) return ''; // Only show on the first row
            //     //  $btn1 =   "edit";
            //     if ($row->requesttype == 'New') {
            //         //  $btn1 = '<a href="'.\route('editquarter', $row->requestid).'" class="btn btn-success "><i class="fas fa-edit"></i></a> ';
            //         $btn1 = '<a href="' . \route('editquarter_a', ['r' =>  base64_encode($row->requestid), 'rv' =>  base64_encode($row->rivision_id)]) . '" class="btn btn-success "><i class="fas fa-edit"></i></a>';
            //     } else {
            //         $btn1 = '<a href="' . \route('editquarter_b', ['r' =>  base64_encode($row->requestid), 'rv' =>  base64_encode($row->rivision_id)]) . '" class="btn btn-success "><i class="fas fa-edit"></i></a>';
            //     }
            //     return $btn1;
            // })
            ->addColumn('action', function ($row) use ($firstInwardPerQuarterType) {
                if (!isset($firstInwardPerQuarterType[$row->quartertype])) {
                    return '';
                }

                // Compare current row's inward_date with the earliest for its quartertype
                if ($row->inward_date !== $firstInwardPerQuarterType[$row->quartertype]) {
                    return '';
                }

                if ($row->requesttype == 'New') {
                    return '<a href="' . \route('editquarter_a', [
                        'r' => base64_encode($row->requestid),
                        'rv' => base64_encode($row->rivision_id),
                        'uid' => base64_encode($row->uid)
                    ]) . '" class="btn btn-success"><i class="fas fa-edit"></i></a>';
                } else {
                    return '<a href="' . \route('editquarter_b', [
                        'r' => base64_encode($row->requestid),
                        'rv' => base64_encode($row->rivision_id),
                        'uid' => base64_encode($row->uid)
                    ]) . '" class="btn btn-success"><i class="fas fa-edit"></i></a>';
                }
            })
            /* ->addColumn('delete', function($row){
         $btn1 ='<a href="' . \URL::action('QuartersController@uploaddocument'). "?r=" . base64_encode($row->requestid)."&type=". base64_encode($row->type)."&rev=". base64_encode($row->rivision_id).'" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>';
         return $btn1;
     })*/
            ->rawColumns(['delete', 'action'])
            ->make(true);
    }
    public function requestchange(Request $request)
    {
        // Step 1: Retrieve user ID from the session
        $uid = Session::get('Uid');
        $basic_pay = Session::get('basic_pay');
        $officecode = session('officecode');
        $cardex_no = session('cardex_no');
        $ddo_code = session('ddo_code');
        //dd($officecode,$cardex_no,$ddo_code,$basic_pay,$q_officecode);
        // Step 2: Check if the user profile is complete
        if ($basic_pay == null) {
            return redirect('profile')->with('failed', "Please complete your profile.");
        }

        // Step 3: Get the user data from the User model
        $userdata = User::where('id', $uid)->first();
        // dd($userdata);
        // Step 4: Check if user exists
        if (!$userdata) {
            return redirect('profile')->with('message', "User not found.");
        } else if ($basic_pay != null && $cardex_no == null && $ddo_code == null && $officecode == null) //21-01-2025
        {

            $this->_viewContent['page_title'] = "DDO Details";
            $this->_viewContent['page'] = 'request_change';
            return view('user/user_ddo_detail', $this->_viewContent);
        }
        // Step 5: Prepare the data array for the view
        $data = [
            'name' => $userdata->name,
            'designation' => $userdata->designation,
            'is_dept_head' => $userdata->is_dept_head,
            'appointment_date' => $userdata->date_of_appointment ? Carbon::parse($userdata->date_of_appointment)->format('d-m-Y') : '',
            'address' => $userdata->address,
            'retirement_date' => $userdata->date_of_retirement ? Carbon::parse($userdata->date_of_retirement)->format('d-m-Y') : '',
            'gpfnumber' => $userdata->gpfnumber,
            'salary_slab' => $userdata->salary_slab,
            'actual_salary' => $userdata->actual_salary,
            'basicpay' => $userdata->basic_pay,
            'personalpay' => $userdata->personal_salary,
            'specialpay' => $userdata->special_salary,
            'deputationpay' => $userdata->deputation_allowance,
            'maratialstatus' => $userdata->maratial_status,
            'officename' => $userdata->office,
            'image' => $userdata->image,
            'is_transfarable' => $userdata->is_transferable,
            'office_address' => $userdata->office_address,
            'office_phone' => $userdata->office_phone,
        ];

        // Step 6: Compute total pay
        $data['totalpay'] = $data['basicpay'] + $data['personalpay'] + $data['specialpay'] + $data['deputationpay'];

        // Step 7: Fetch Current Quarter
        $currentQuarter = QuarterAllotment::where('uid', $uid)
            ->where('isoccupied', 'Y')
            ->orderBy('occupancy_date', 'desc')
            ->first();

        $currentReadonly = '';
        $allottedReadonly = '';
        $wo_unitno = $wo_blockno = $wo_qaid = $cur_qaid = $cur_quartertype = $cur_areacode = $cur_block_no = $cur_unitno = $possesiondate = $wo_areacode = null;

        // Initialize the variable for the allotted quarter type (wo_quartertype)
        $wo_quartertype = null;

        if (!$currentQuarter) {
            // Fetch Allotted Quarter
            $allottedQuarter = QuarterAllotment::where('uid', $uid)
                ->where('isoccupied', 'N')
                ->orderBy('allotment_date', 'desc')
                ->first();

            if ($allottedQuarter) {
                $wo_qaid = $allottedQuarter->qaid;
                $wo_quartertype = $allottedQuarter->quartertype;  // This should be set correctly when allotted quarter exists
                $wo_areacode = $allottedQuarter->areacode;
                $wo_blockno = $allottedQuarter->block_no;
                $wo_unitno = $allottedQuarter->unitno;
                $allottedReadonly = "disabled";
            }
        } else {
            // Set current quarter data
            $cur_qaid = $currentQuarter->qaid;
            $cur_quartertype = $currentQuarter->quartertype;
            $cur_areacode = $currentQuarter->areacode;
            $cur_block_no = $currentQuarter->block_no;
            $cur_unitno = $currentQuarter->unitno;
            $possesiondate = $currentQuarter->occupancy_date;
            $currentReadonly = "disabled";
        }

        // Step 8: Fetch the quarter type based on basic pay
        $quartertype = QuarterType::where('bpay_from', '<=', $basic_pay)
            ->where('bpay_to', '>=', $basic_pay)
            ->orderBy('bpay_from')
            ->first();

        // Prepare quarter type select options
        $quartertypeopt = "<option value=''>-- Select --</option>";
        if ($quartertype) {
            $quartertypeopt .= "<option value='" . $quartertype->quartertype . "'>" . $quartertype->quartertype_g . "</option>";
        }

        // Step 9: Fetch all quarter types, ordered by 'BpayFrom' in descending order
        $quartertypes = QuarterType::orderBy('bpay_from', 'desc')->get();
        $oldqtypeopt = "<option value=''>-- Select --</option>";
        $woqtypeopt = "<option value=''>-- Select --</option>";

        foreach ($quartertypes as $qt) {
            $selectedoq = ($qt->quartertype == $cur_quartertype) ? 'selected' : '';
            $oldqtypeopt .= "<option value='" . $qt->quartertype . "' $selectedoq>" . $qt->quartertype_g . "</option>";

            $selectedwo = ($qt->quartertype == $wo_quartertype) ? 'selected' : '';
            $woqtypeopt .= "<option value='" . $qt->quartertype . "' $selectedwo>" . $qt->quartertype_g . "</option>";
        }

        // Step 10: Fetch the sectors (areas) based on quarter type
        $sectors = DB::table('master.m_quarters as mq')
            ->distinct()
            ->select('mq.areacode', 'ma.areaname')
            ->join('master.m_area as ma', 'ma.areacode', '=', 'mq.areacode')  // Proper aliasing of the tables
            ->where('mq.quartertype', $quartertype->quartertype)
            ->orderBy('ma.areaname', 'desc')  // Proper column aliasing
            ->get();

        $areaopt = "<option value=''>-- Select --</option>";
        $woareaopt = "<option value=''>-- Select --</option>";

        foreach ($sectors as $area) {
            $selected = ($area->areacode == $cur_areacode) ? 'selected' : '';
            $areaopt .= "<option value='" . $area->areacode . "' $selected>" . $area->areaname . "</option>";

            $selected = ($area->areacode == $wo_areacode) ? 'selected' : '';
            $woareaopt .= "<option value='" . $area->areacode . "' $selected>" . $area->areaname . "</option>";
        }

        // Step 11: Fetch all available areas for the open selection
        $openareaopt = "<option value=''>-- Select --</option>";
        $areas = Area::orderBy('areacode')->get();
        foreach ($areas as $area) {
            $openareaopt .= "<option value='" . $area->areacode . "'>" . $area->areaname . "</option>";
        }

        // Step 12: Prepare marital status options
        $mrg = ['M' => 'Married', 'U' => 'Unmarried'];
        $maratialstatusopt = "<option value=''>-- Select --</option>";
        foreach ($mrg as $key => $value) {
            $selected = ($key == $userdata->maratial_status) ? 'selected' : '';
            $maratialstatusopt .= "<option value='$key' $selected>$value</option>";
        }

        // Step 13: Merge all view data
        $imageData = generateImage($uid);
        // Assign the image data to the data array to be passed to the view
        $data['imageData'] = $imageData;
        $this->_viewContent['quartertypeopt'] = $quartertypeopt;
        $this->_viewContent['oldqtypeopt'] = $oldqtypeopt;
        $this->_viewContent['woqtypeopt'] = $woqtypeopt;
        $this->_viewContent['areaopt'] = $areaopt;
        $this->_viewContent['woareaopt'] = $woareaopt;
        $this->_viewContent['openareaopt'] = $openareaopt;
        $this->_viewContent['maratialstatusopt'] = $maratialstatusopt;
        $this->_viewContent['currentReadonly'] = $currentReadonly;
        $this->_viewContent['allottedReadonly'] = $allottedReadonly;
        $this->_viewContent['cur_qaid'] = $cur_qaid;
        $this->_viewContent['cur_blockno'] = $cur_block_no;
        $this->_viewContent['cur_unitno'] = $cur_unitno;
        $this->_viewContent['possesiondate'] = $possesiondate;
        $this->_viewContent['wo_qaid'] = $wo_qaid;
        $this->_viewContent['wo_blockno'] = $wo_blockno;
        $this->_viewContent['wo_unitno'] = $wo_unitno;

        $this->_viewContent['page_title'] = "Change Request";
        //dd($this->_viewContent['areaopt']);
        // Step 14: Return the view with the data
        return view('user.changeQuarterRequest', array_merge($this->_viewContent, $data));
    }

    public function updateFileStatusAdmin(Request $request)
    {
        // Validate the incoming request
        // $request->validate([
        //     'doc_id' => 'required|integer',
        //     'is_file_ddo_verified' => 'required|in:1,2',
        // ]);
        //dd("hello");
        // Get the document ID and checked status
        $docId = $request->input('doc_id');
        //dd($docId);
        $isVerified = $request->input('is_file_admin_verified'); // 1 for checked, 2 for unchecked

        // Update the file status
        FileList::where('doc_id', $docId)
            ->update(['is_file_admin_verified' => $isVerified]);

        // Return a success response
        return response()->json(['success' => true]);
    }
    public function getDDOCode(Request $request)
    {
        // Validate the input
        $request->validate([
            'cardex_no' => 'required|string',
        ]);

        $cardexNo = $request->input('cardex_no');
        $dcode = $request->input('dcode');

        // Fetch data from your database based on cardex_no
        //$data = DDOCode::where('cardex_no', '=', $cardexNo)->get(['ddo_code', 'ddo_office']); // Adjust fields as necessary
        $data = DDOCode::where('cardex_no', '=', $cardexNo)
            ->where('dcode', '=', $dcode)
            ->get(['ddo_code', 'ddo_office']); // Adjust fields as necessary

        return response()->json($data);
    }
    //3/1/2025
    public function saveOfficeCode(Request $request)
    {
        $rules = [
            'cardex_no' => 'required',
            'ddo_code' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect('quartersuser')->withInput()->withErrors($validator);
        }
        try {
            $uid = Session::get('Uid');
            //  dd($uid);
            // dd($request->page);
            $data = DDOCode::select('officecode', 'cardex_no', 'ddo_code')->where('cardex_no', '=', $request->input('cardex_no'))->where('ddo_code', '=', $request->input('ddo_code'))->first();
            $updatedata = User::where('id', $uid)
                ->update(['cardex_no' => $request->input('cardex_no'), 'ddo_code' => $request->input('ddo_code')]);
            //dd($data);
            if (!$data) {
                // If no data is found, redirect back with an error message
                return redirect()->back()->with('error', 'No matching data found.');
            }
            //session(['q_officecode' => $data->officecode]);
            session(['officecode' => $data->officecode]);
            session(['cardex_no' => $data->cardex_no]);
            session(['ddo_code' => $data->ddo_code]);
            //dd($request->page);
            if ($request->page == 'new_request') {
                return redirect('quartersuser');
            } else if ($request->page == 'higher_request') {
                return redirect('quartershigher');
            } else if ($request->page == 'change_request') {
                return redirect('quarterschange');
            } else {
                return redirect()->route('user.ddo_details');
            }
        } catch (Exception $e) {
            dd($e->getMessage());
            return redirect('session save')->with('failed', "operation failed");
        }
    }
    public function addnewremarks(Request $request)
    {

        $new_remarks = base64_decode($request->new_remark);

        $request->validate([
            'new_remark' => 'required',
        ], [
            'new_remark.required' => 'Please enter a new remark.',
        ]);

        // Clean input to remove HTML tags
        $remarks = strip_tags($new_remarks);

        try {

            $newRemark = Remarks::create([

                'description' => $remarks,
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
            // Return success response
            return response()->json([
                'status' => 'success',
                'message' => 'Remark added successfully!',

            ]);
        } catch (Exception $e) {
            dd($e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to add remark: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function listremarks(Request $request)
    {
        $remarksData = json_decode($request->input('remarks_selected'), true);

        // Extract the remarks value (e.g., "2,3,4")
        $remarksString = $remarksData['remarks'] ?? '';

        // Convert to array
        $remarksArray = explode(',', $remarksString);

        //dd($request->all());
        try {

            // Pagination variables
            // Get the limit and offset (pagination) values from the DataTable request
            $limit = $request->input('length', 10);  // Default to 10 if not provided
            $offset = $request->input('start', 0);   // Default to 0 if not provided
            $page = $request->input('page', 1);  // Default to page 1 if not provided
            $search = '';
            if ($request->has('search')) {
                $search = $request->get('search')['value']; // Get the global search term
            }
            //dd($limit,$offset,$search);
            // Fetch the paginated data
            $data  = Remarks::select('remark_id', 'description')
                ->when($search, function ($query) use ($search) {
                    // Add the search condition to the query if the search term is present
                    $query->where(function ($q) use ($search) {
                        $q->where('description', 'ilike', "%$search%");
                    });
                })->skip($offset)->take($limit)->orderBy('remark_id', 'DESC')->get();
            // dd($data);
            // Get total records count for pagination (without filtering)

            $totalRecords = Remarks::count();

            // Get the filtered records count (filtered by the same query as $data)
            $filteredRecords  = Remarks::select('remark_id', 'description')
                ->when($search, function ($query) use ($search) {
                    // Add the search condition to the query if the search term is present
                    $query->where(function ($q) use ($search) {
                        $q->where('description', 'ilike', "%$search%");
                    });
                })
                ->count();  // Count the total number of records matching the query (without pagination)
            //dd($filteredRecords);
            // Return the DataTables response with pagination data and custom columns
            return response()->json([
                'draw' => $request->get('draw'),
                'recordsTotal' => $totalRecords,
                'recordsFiltered' => $filteredRecords,
                'data' => $data->map(function ($row, $index) use ($offset, $remarksArray) {

                    $isChecked = in_array($row->remark_id, $remarksArray) ? 'checked' : '';

                    $checkbox = '<input type="checkbox" name="remarksArr[]" id="' . htmlspecialchars($row->remark_id, ENT_QUOTES, 'UTF-8') . '" value="' . htmlspecialchars($row->remark_id, ENT_QUOTES, 'UTF-8') . '" onclick="SelectRemarks(this);" ' . $isChecked . ' />';

                    // (Optional) Define the checkbox value
                    //  $checkbox = '<input type="checkbox"  name="remarksArr[]"  id="' . htmlspecialchars($row->remark_id, ENT_QUOTES, 'UTF-8') . '"value="' . htmlspecialchars($row->remark_id, ENT_QUOTES, 'UTF-8') . '" onclick="SelectRemarks(this);" />';

                    return [
                        'index' => $offset + $index + 1,  // Add the index column (starts from 1)
                        'checkbox' => $checkbox, //Add checkbox as a column
                        'description' => $row->description

                    ];
                })
            ]);
        } catch (Exception $e) {
            dd($e->getMessage());
            // Log::error('Error fetching reconciliation list: ' . $e->getMessage());
            return response()->json(['error' => 'Error fetching data.'], 500);
        }
    }
    public function admin_quartersRejected()
    {
        $this->_viewContent['page_title'] = "Request Rejected";
        return view('request.quartersrejected', $this->_viewContent);
    }
    public function admin_getRejectedQuarterList(Request $request)
    {
        $officecode = Session::get('officecode');
        //dd($officecode);
        //DB::enableQueryLog();
        $first = Tquarterrequesta::from('master.t_quarter_request_a AS a')->select([
            'request_date',
            DB::raw("'a'::text as type"),
            DB::raw("'New'::text as requesttype"),
            'requestid',
            'quartertype',
            'inward_no',
            'inward_date',
            'a.uid',
            'u.name',
            'u.designation',
            'office',
            'rivision_id',
            'a.remarks',
            'contact_no',
            'address',
            'gpfnumber',
            'is_accepted',
            'is_allotted',
            'is_varified',
            'email',
            'remarks_date',
            'is_priority',
            'is_ddo_varified',
            'officecode'

        ])
            ->join('userschema.users as u', 'u.id', '=', 'a.uid');

        $second = Tquarterrequestc::from('master.t_quarter_request_c AS c')->select([
            'request_date',
            DB::raw("'c' as type"),
            DB::raw("'Change' as requesttype"),
            'requestid',
            'quartertype',
            'inward_no',
            'inward_date',
            'c.uid',
            'u.name',
            'u.designation',
            'office',
            'rivision_id',
            'c.remarks',
            'contact_no',
            'address',
            'gpfnumber',
            'is_accepted',
            'is_allotted',
            'is_varified',
            'email',
            'remarks_date',
            'is_priority',
            'is_ddo_varified',
            'officecode'
        ])
            ->join('userschema.users as u', 'u.id', '=', 'c.uid');
        $union = Tquarterrequestb::from('master.t_quarter_request_b AS b')->select([
            'request_date',
            DB::raw("'b'::text as type"),
            DB::raw("'Higher Category'::text  as requesttype"),
            'requestid',
            'quartertype',
            'inward_no',
            'inward_date',
            'b.uid',
            'u.name',
            'u.designation',
            'office',
            'rivision_id',
            'b.remarks',
            'contact_no',
            'address',
            'gpfnumber',
            'is_accepted',
            'is_allotted',
            'is_varified',
            'email',
            'remarks_date',
            'is_priority',
            'is_ddo_varified',
            'officecode'
        ])
            ->join('userschema.users as u', 'u.id', '=', 'b.uid')
            ->union($first)
            ->union($second);

        $query = DB::table(DB::raw("({$union->toSql()}) as x"))
            ->select([
                'type',
                'requesttype',
                'requestid',
                'quartertype',
                'inward_no',
                'inward_date',
                'uid',
                'name',
                'designation',
                'office',
                'rivision_id',
                'remarks',
                'contact_no',
                'address',
                'gpfnumber',
                'is_accepted',
                'is_allotted',
                'is_varified',
                'email',
                'request_date',
                'remarks_date',
                'is_priority',
                'is_ddo_varified',
                'officecode'

            ])
            ->where(function ($query) use ($officecode) {
                $query->where('is_accepted', '=', 1)
                    ->whereNotNull('remarks')
                    //->where('is_varified', '=', 0)
                    ->where('is_priority', '=', 'N')
                    ->where('is_ddo_varified', '=', 1)
                    ->where('officecode', '=', $officecode)
                    ->whereIn('is_varified', [0, 2])
                    ->orderBy('wno'); // assuming 'wno' is a column in the database
            })
            ->orderBy('remarks_date');
        // Print the SQL query
        //dd( $query->toSql());
        //     dd("hello");

        return Datatables::of($query)
            ->addColumn('inward_date', function ($date) {
                if ($date->inward_date == '')  return 'N/A';

                return date('d-m-Y', strtotime($date->inward_date));
            })
            ->addColumn('request_date', function ($date) {
                if ($date->request_date == '')  return 'N/A';

                return date('d-m-Y', strtotime($date->request_date));
            })
            ->addColumn('remarks_date', function ($date) {
                if ($date->remarks_date == '')  return 'N/A';

                return date('d-m-Y', strtotime($date->remarks_date));
            })

            ->addColumn('action', function ($row) {
                $btn1 = '';
                //  $btn1 = '<a href="'.\route('editquarter', $row->requestid).'" class="btn btn-success "><i class="fas fa-edit"></i></a> ';
                // $btn1 = '<a href="' . \route('editquarter_a', ['r' =>  base64_encode($row->requestid), 'rv' =>  base64_encode($row->rivision_id)]) . '" class="btn btn-success "><i class="fas fa-edit"></i>&nbsp;View Remarks</a>';
                $btn2 = '<button type="button" data-uid="' . base64_encode($row->uid) . '" data-rivision_id="' . base64_encode($row->rivision_id) . '"data-type="' . base64_encode($row->type) . '"  data-requestid="' . base64_encode($row->requestid) . '"  data-remarks="' . base64_encode($row->remarks) . '" data-toggle="modal"  class=" btn-view-custom getdocument" > View Remarks</button>';

                return $btn1 . $btn2;
            })

            /* ->addColumn('delete', function($row){
         $btn1 ='<a href="' . \URL::action('QuartersController@uploaddocument'). "?r=" . base64_encode($row->requestid)."&type=". base64_encode($row->type)."&rev=". base64_encode($row->rivision_id).'" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>';
         return $btn1;
     })*/
            ->rawColumns(['action'])
            ->make(true);
    }
    public function getremarks(Request $request)
    {

        $uid = base64_decode($request->uid);
        $type = base64_decode($request->type);
        $rivision_id = base64_decode($request->rivision_id);
        $requestid = base64_decode($request->requestid);
        $remarks = base64_decode($request->remarks);



        //  return response()->json($remarksdata);

        if ($remarks == '') {
            return response()->json([
                'success' => false,
                'data' => [],
                'message' => 'No Data Found'
            ]);
        } else {
            $remarksArray = explode(',', $remarks);
            $remarksdata = Remarks::select('description')->whereIn('remark_id', $remarksArray)->get();
            return response()->json([
                'success' => true,
                'data' => $remarksdata
            ]);
        }
    }
    public function uploaddocument()
    {

        $request_id = base64_decode($_REQUEST['r']);
        $type = base64_decode($_REQUEST['type']);
        $rev = base64_decode($_REQUEST['rev']);
        //dd($request_id,$type,$rev);

        // Fetch user-specific details (only once)
        $user = User::find(Session::get('Uid'));

        $excludedDocumentTypes = [6,  10];


        if ($type == 'a') {
            $ddo_remarks = Tquarterrequesta::where('requestid', $request_id)->select('is_ddo_varified', 'ddo_remarks')->first();
            $admin_remarks = Tquarterrequesta::where('requestid', $request_id)->select('is_varified', 'remarks')->first();
            $wno = Tquarterrequesta::where('requestid', $request_id)->select('wno')->first();
            $this->_viewContent['ddo_remarks_status'] = $ddo_remarks;
            $this->_viewContent['admin_remarks_status'] = $admin_remarks;
        } else if ($type == 'b') {
            $ddo_remarks = Tquarterrequestb::where('requestid', $request_id)->select('is_ddo_varified', 'ddo_remarks')->first();
            $admin_remarks = Tquarterrequestb::where('requestid', $request_id)->select('is_varified', 'remarks')->first();
            $wno = Tquarterrequestb::where('requestid', $request_id)->select('wno')->first();
            $this->_viewContent['ddo_remarks_status'] = $ddo_remarks;
            $this->_viewContent['admin_remarks_status'] = $admin_remarks;
        }
        //  dd($request_id,$type,$rev,$wno['wno'],$ddo_remarks,$admin_remarks);
        // \DB::enableQueryLog();
        //19-11-2024 to show polics staff ceriticate if user is police staff

        if ($ddo_remarks['ddo_remarks'] == '' && $admin_remarks['remarks'] == '' && $wno['wno'] == '') {

            $document_list = Documenttype::where('performa', 'LIKE', '%' . $type . '%')
                ->whereNotIn('document_type', [6]) // Exclude certain document types
                ->whereNotIn('document_type', function ($query) use ($type, $request_id, $rev) {
                    $query->select('document_id')  // Select the correct column (document_id)
                        ->from('master.file_list')
                        ->whereIn('master.file_list.is_file_ddo_verified', [0, 1])       // Correct table name (assuming it's 'filelists')
                        ->whereIn('master.file_list.is_file_admin_verified', [0, 1])       // Correct table name (assuming it's 'filelists')
                        ->where('master.file_list.performa', 'LIKE', '%' . $type . '%')
                        ->WHERE('request_id', $request_id)
                        ->where('rivision_id', $rev)
                        ->where('uid', Session::get('Uid'));  // Correct the condition for 'uid'
                })
                // Conditionally add the exclusion for document type 8 based on the user's role
                ->when(User::where('id', Session::get('Uid'))->value('is_police_staff') == 'N', function ($query) {
                    // Only apply this whereNotIn condition if the user is not a police staff
                    return $query->whereNotIn('document_type', [8]);  // Exclude document type 8
                })
                // Conditionally add the exclusion for document type 8 based on the user's role fix pay staff
                ->when(User::where('id', Session::get('Uid'))->value('is_fix_pay_staff') != 'Y', function ($query) {
                    // Only apply this whereNotIn condition if the user is not a police staff
                    return $query->whereNotIn('document_type', [7]);  // Exclude document type 8
                })
                ->when(
                    // Add the condition to check if 'is_phy_dis' is 'Y' and 'dis_per' is less than 60, or if 'is_phy_dis' is 'N'
                    (User::where('id', Session::get('Uid'))->value('is_phy_dis') == 'Y' &&
                        User::where('id', Session::get('Uid'))->value('dis_per') <= 60) ||
                        User::where('id', Session::get('Uid'))->value('is_phy_dis') == 'N',
                    function ($query) {
                        // Exclude document type 9 for users who are either physically disabled with dis_per <= 60 or is_phy_dis == 'N'
                        return $query->whereNotIn('document_type', [9]);
                    }
                )
                ->pluck('document_name', 'document_type');

            // $lastQuery = DB::getQueryLog();
            //  print_r($lastQuery);
            // // Get the last query executed
            //    $query = end($lastQuery);

            // // Print the SQL query and bindings for debugging
            // dd($query['query'], $query['bindings']);
            $attacheddocument = DB::table('master.file_list')
                ->join('master.m_document_type', 'master.file_list.document_id', '=', 'master.m_document_type.document_type')
                ->whereNotIn('document_id', [6])
                ->WHERE('uid', Session::get('Uid'))
                ->WHERE('request_id', $request_id)
                ->where('rivision_id', $rev)
                ->WHERE('master.file_list.performa', 'LIKE', '%' . $type . '%')
                ->where(function ($query) {
                    $query->whereIn('master.file_list.is_file_ddo_verified', [0, 2])
                        ->orWhereIn('master.file_list.is_file_admin_verified', [0, 2]);
                })
                //  ->whereIn('master.file_list.is_file_ddo_verified', [0, 1])
                //  ->whereIn('master.file_list.is_file_admin_verified', [0, 1])
                ->select('rev_id', 'doc_id', 'document_name')
                ->get();



            // dd($document_list,$attacheddocument);
            //dd( $attacheddocument );
        } else if ($ddo_remarks['ddo_remarks'] != '' && $admin_remarks['remarks'] == '') {
            // dd("hello");
            $document_list = Documenttype::where('performa', 'LIKE', '%' . $type . '%')
                ->whereNotIn('document_type', [6]) // Exclude certain document types
                ->whereIn('document_type', function ($query) use ($type, $request_id, $rev) {
                    $query->select('document_id')  // Select the correct column (document_id)
                        ->from('master.file_list')
                        ->whereIn('master.file_list.is_file_ddo_verified', [2])       // Correct table name (assuming it's 'filelists')
                        //->whereIn('master.file_list.is_file_admin_verified', [0,1])       // Correct table name (assuming it's 'filelists')
                        ->WHERE('request_id', $request_id)
                        ->where('rivision_id', $rev)
                        ->where('master.file_list.performa', 'LIKE', '%' . $type . '%')
                        ->where('uid', Session::get('Uid'));  // Correct the condition for 'uid'
                })
                // Conditionally add the exclusion for document type 8 based on the user's role
                ->when(User::where('id', Session::get('Uid'))->value('is_police_staff') == 'N', function ($query) {
                    // Only apply this whereNotIn condition if the user is not a police staff
                    return $query->whereNotIn('document_type', [8]);  // Exclude document type 8
                })
                // Conditionally add the exclusion for document type 8 based on the user's role fix pay staff
                ->when(User::where('id', Session::get('Uid'))->value('is_fix_pay_staff') != 'Y', function ($query) {
                    // Only apply this whereNotIn condition if the user is not a police staff
                    return $query->whereNotIn('document_type', [7]);  // Exclude document type 8
                })
                ->when(
                    // Add the condition to check if 'is_phy_dis' is 'Y' and 'dis_per' is less than 60, or if 'is_phy_dis' is 'N'
                    (User::where('id', Session::get('Uid'))->value('is_phy_dis') == 'Y' &&
                        User::where('id', Session::get('Uid'))->value('dis_per') <= 60) ||
                        User::where('id', Session::get('Uid'))->value('is_phy_dis') == 'N',
                    function ($query) {
                        // Exclude document type 9 for users who are either physically disabled with dis_per <= 60 or is_phy_dis == 'N'
                        return $query->whereNotIn('document_type', [9]);
                    }
                )
                ->pluck('document_name', 'document_type');

            //$lastQuery = DB::getQueryLog();
            //  print_r($lastQuery);
            // Get the last query executed
            //$query = end($lastQuery);

            // Print the SQL query and bindings for debugging
            // dd($query['query'], $query['bindings']);
            // dd($document_list);
            $attacheddocument = DB::table('master.file_list')
                ->join('master.m_document_type', 'master.file_list.document_id', '=', 'master.m_document_type.document_type')
                ->whereNotIn('document_id', [6])
                ->WHERE('uid', Session::get('Uid'))
                ->WHERE('request_id', $request_id)
                ->where('rivision_id', $rev)
                ->WHERE('master.file_list.performa', 'LIKE', '%' . $type . '%')
                ->where(function ($query) {
                    $query->whereIn('master.file_list.is_file_ddo_verified', [0, 2]);
                })
                //  ->whereIn('master.file_list.is_file_ddo_verified', [0, 2])
                //  ->whereIn('master.file_list.is_file_admin_verified', [0, 2])
                ->select('rev_id', 'doc_id', 'document_name')
                ->get();
            // dd( $attacheddocument );
        } else if ($ddo_remarks['ddo_remarks'] == '' && $admin_remarks['remarks'] != '') {
            // dd($admin_remarks);
            //dd("hello");
            $document_list = Documenttype::where('performa', 'LIKE', '%' . $type . '%')
                ->whereNotIn('document_type', [6]) // Exclude certain document types
                ->whereIn('document_type', function ($query) use ($type, $request_id, $rev) {
                    $query->select('document_id')  // Select the correct column (document_id)
                        ->from('master.file_list')
                        //  ->whereIn('master.file_list.is_file_ddo_verified', [2])       // Correct table name (assuming it's 'filelists')
                        ->whereIn('master.file_list.is_file_admin_verified', [0, 2])       // Correct table name (assuming it's 'filelists')
                        ->WHERE('request_id', $request_id)
                        ->where('rivision_id', $rev)
                        ->where('master.file_list.performa', 'LIKE', '%' . $type . '%')
                        ->where('uid', Session::get('Uid'));  // Correct the condition for 'uid'
                })
                // Conditionally add the exclusion for document type 8 based on the user's role
                ->when(User::where('id', Session::get('Uid'))->value('is_police_staff') == 'N', function ($query) {
                    // Only apply this whereNotIn condition if the user is not a police staff
                    return $query->whereNotIn('document_type', [8]);  // Exclude document type 8
                })
                // Conditionally add the exclusion for document type 8 based on the user's role fix pay staff
                ->when(User::where('id', Session::get('Uid'))->value('is_fix_pay_staff') != 'Y', function ($query) {
                    // Only apply this whereNotIn condition if the user is not a police staff
                    return $query->whereNotIn('document_type', [7]);  // Exclude document type 8
                })
                ->when(
                    // Add the condition to check if 'is_phy_dis' is 'Y' and 'dis_per' is less than 60, or if 'is_phy_dis' is 'N'
                    (User::where('id', Session::get('Uid'))->value('is_phy_dis') == 'Y' &&
                        User::where('id', Session::get('Uid'))->value('dis_per') <= 60) ||
                        User::where('id', Session::get('Uid'))->value('is_phy_dis') == 'N',
                    function ($query) {
                        // Exclude document type 9 for users who are either physically disabled with dis_per <= 60 or is_phy_dis == 'N'
                        return $query->whereNotIn('document_type', [9]);
                    }
                )
                ->pluck('document_name', 'document_type');

            //     $lastQuery = DB::getQueryLog();
            //      print_r($lastQuery);
            // // Get the last query executed
            //   $query = end($lastQuery);

            // Print the SQL query and bindings for debugging
            //    dd($query['query'], $query['bindings']);
            //     dd($document_list);

            $attacheddocument = DB::table('master.file_list')
                ->join('master.m_document_type', 'master.file_list.document_id', '=', 'master.m_document_type.document_type')
                ->whereNotIn('document_id', [6])
                ->WHERE('uid', Session::get('Uid'))
                ->WHERE('request_id', $request_id)
                ->where('rivision_id', $rev)
                ->WHERE('master.file_list.performa', 'LIKE', '%' . $type . '%')
                ->where(function ($query) {
                    $query->whereIn('master.file_list.is_file_ddo_verified', [0, 2])
                        ->orWhereIn('master.file_list.is_file_admin_verified', [0, 2]);
                })
                //  ->whereIn('master.file_list.is_file_ddo_verified', [0, 2])
                //  ->whereIn('master.file_list.is_file_admin_verified', [0, 2])
                ->select('rev_id', 'doc_id', 'document_name')
                ->get();
        } else if ($ddo_remarks['ddo_remarks'] == '' && $admin_remarks['remarks'] == '' && $wno['wno'] != '') {
            $document_list = "";
            $attacheddocument = DB::table('master.file_list')
                ->join('master.m_document_type', 'master.file_list.document_id', '=', 'master.m_document_type.document_type')
              //  ->whereNotIn('document_id', [6])
                ->WHERE('uid', Session::get('Uid'))
                ->WHERE('request_id', $request_id)
                ->where('rivision_id', $rev)
                ->WHERE('master.file_list.performa', 'LIKE', '%' . $type . '%')
                // ->where(function ($query) {
                //     $query->whereIn('master.file_list.is_file_ddo_verified', [0, 2])
                //           ->orWhereIn('master.file_list.is_file_admin_verified', [0, 2]);
                // })
                //  ->whereIn('master.file_list.is_file_ddo_verified', [0, 2])
                //  ->whereIn('master.file_list.is_file_admin_verified', [0, 2])
                ->select('rev_id', 'doc_id', 'document_name')
                ->get();
            // dd( $attacheddocument );
        }
        //dd($ddo_remarks);

        $this->_viewContent['page_title'] = "Upload Document";

        $this->_viewContent['document_list'] = $document_list;

        $this->_viewContent['attacheddocument'] = $attacheddocument;

        $this->_viewContent['request_id'] = $request_id;
        $this->_viewContent['rev'] = $rev;
        $this->_viewContent['type'] = $type;
        //dd($this->_viewContent);
        return view('user/documentupload', $this->_viewContent);
    }

    public function getCardexNo(Request $request)
    {
        // Validate the input
        $request->validate([
            'dcode' => 'required|string',
        ]);

        $dcode = $request->input('dcode');
        //dd($dcode);
        // Fetch data from your database based on cardex_no
        // $data = DDOCode::where('cardex_no', '=', $cardexNo)->get(['ddo_code', 'ddo_office']); // Adjust fields as necessary
        $district = strtoupper(getDistrictByCode($dcode));

        // dd($district);
        //$data = DDOCode::where('district', $district)->orderBy('cardex_no')->pluck('cardex_no');
        $data = DDOCode::where('dcode', $dcode)->orderBy('cardex_no')->pluck('cardex_no');

        //dd($data);
        return response()->json($data);
    }
    public function savefinalannexure(request $request)
    {
        $requestid = $request->requestid;
        $downgrade_requestid = $request->dgr;
        $rev = $request->rev;
        $type = $request->type;

        //dd($request->type);
        // dd( $rev);
        //dd(Session::get('Uid'));
        if ($type == 'a') {
            $ddo_remarks = Tquarterrequesta::where('requestid', $requestid)->select('is_ddo_varified', 'ddo_remarks')->first();
            $admin_remarks = Tquarterrequesta::where('requestid', $requestid)->select('is_varified', 'remarks')->first();
            $wno = Tquarterrequesta::where('requestid', $requestid)->select('wno')->first();
        } else if ($type == 'b') {
            $ddo_remarks = Tquarterrequestb::where('requestid', $requestid)->select('is_ddo_varified', 'ddo_remarks')->first();
            $admin_remarks = Tquarterrequestb::where('requestid', $requestid)->select('is_varified', 'remarks')->first();
            $wno = Tquarterrequestb::where('requestid', $requestid)->select('wno')->first();
        }
        DB::enableQueryLog();
        if ($request->type == 'a') {
            $result = Tquarterrequesta::where('requestid', $requestid)
                ->first();
            if ($downgrade_requestid != "") {
                $downgrade_request = Tquarterrequesta::where('requestid', $requestid)
                    ->first();
                $downgrade_quartertype = $downgrade_request->quartertype;
            }

            $quartertype = $result->quartertype;

            // Get user data for is_police_staff
            $isPoliceStaff = User::where('id', Session::get('Uid'))->value('is_police_staff');
            $isFixPayStaff = User::where('id', Session::get('Uid'))->value('is_fix_pay_staff');
            //dd($isPoliceStaff);
            //dd($isFixPayStaff);
            // Count documents where 'performa' contains 'a'
            //$doc_tobe_submit = Documenttype::where('performa', 'like', '%a%')->whereNotIn('document_type', [2, 6, 9, 10,3,7])->count();
            $type = 'a';

            // Count documents where 'performa' contains 'a' and exclude certain document types --19-11-2024
            if ($ddo_remarks['ddo_remarks'] == '' && $admin_remarks['remarks'] == '' && $wno['wno'] == '') {
                //dd("hello");
                $doc_tobe_submit = Documenttype::where('performa', 'like', '%a%')
                    ->whereNotIn('document_type', [6])  // Exclude document types
                    //     ->whereNotIn('document_type', function ($query) use($type) {
                    //     $query->select('document_id')  // Select the correct column (document_id)
                    //         ->from('master.file_list')  
                    //         ->whereIn('master.file_list.is_file_ddo_verified', [0,1])       // Correct table name (assuming it's 'filelists')
                    //         ->whereIn('master.file_list.is_file_admin_verified', [0,1])       // Correct table name (assuming it's 'filelists')
                    //         ->where('master.file_list.performa', 'LIKE', '%' . $type . '%')
                    //         ->where('uid', Session::get('Uid'));  // Correct the condition for 'uid'
                    // })
                    //->when($isPoliceStaff == 'N', function ($query) {
                    ->when(User::where('id', Session::get('Uid'))->value('is_police_staff') == 'N', function ($query) {
                        // If user is not a police staff, exclude document_type = 8
                        return $query->whereNotIn('document_type', [8]);
                    })
                    // Conditionally add the exclusion for document type 8 based on the user's role fix pay staff
                    ->when(User::where('id', Session::get('Uid'))->value('is_fix_pay_staff') == 'N', function ($query) {
                        // Only apply this whereNotIn condition if the user is not a police staff
                        return $query->whereNotIn('document_type', [7]);  // Exclude document type 8
                    })
                    ->when(
                        // Add the condition to check if 'is_phy_dis' is 'Y' and 'dis_per' is less than 60, or if 'is_phy_dis' is 'N'
                        (User::where('id', Session::get('Uid'))->value('is_phy_dis') == 'Y' &&
                            User::where('id', Session::get('Uid'))->value('dis_per') <= 60) ||
                            User::where('id', Session::get('Uid'))->value('is_phy_dis') == 'N',
                        function ($query) {
                            // Exclude document type 9 for users who are either physically disabled with dis_per <= 60 or is_phy_dis == 'N'
                            return $query->whereNotIn('document_type', [9]);
                        }
                    )
                    ->count();
                // ->get();
                $doc_submitted = Filelist::where('request_id', $requestid)
                    //->whereNotIn('document_id', [2, 6, 9, 10, 3, 7])  // Exclude document types
                    ->whereNotIn('document_id', [6])
                    ->where('performa', 'a')
                    ->where('rivision_id', $rev)
                    ->where('uid', Session::get('Uid'))
                    //->when($isPoliceStaff == 'N', function ($query) {
                    ->when(User::where('id', Session::get('Uid'))->value('is_police_staff') == 'N', function ($query) {
                        // If user is not a police staff, exclude document_type = 8
                        return $query->whereNotIn('document_id', [8]);
                    })
                    // Conditionally add the exclusion for document type 8 based on the user's role fix pay staff
                    ->when(User::where('id', Session::get('Uid'))->value('is_fix_pay_staff') == 'N', function ($query) {
                        // Only apply this whereNotIn condition if the user is not a police staff
                        return $query->whereNotIn('document_id', [7]);  // Exclude document type 8
                    })
                    ->when(
                        // Add the condition to check if 'is_phy_dis' is 'Y' and 'dis_per' is less than 60, or if 'is_phy_dis' is 'N'
                        (User::where('id', Session::get('Uid'))->value('is_phy_dis') == 'Y' &&
                            User::where('id', Session::get('Uid'))->value('dis_per') <= 60) ||
                            User::where('id', Session::get('Uid'))->value('is_phy_dis') == 'N',
                        function ($query) {
                            // Exclude document type 9 for users who are either physically disabled with dis_per <= 60 or is_phy_dis == 'N'
                            return $query->whereNotIn('document_id', [9]);
                        }
                    )->count();
            } else if ($ddo_remarks['ddo_remarks'] != '' && $admin_remarks['remarks'] == '') {
                //dd("Test");
                $doc_tobe_submit = Documenttype::where('performa', 'like', '%a%')
                    ->whereNotIn('document_type', [6])  // Exclude document types
                    ->whereIn('document_type', function ($query) use ($type) {
                        $query->select('document_id')  // Select the correct column (document_id)
                            ->from('master.file_list')
                            ->whereIn('master.file_list.is_file_ddo_verified', [2])       // Correct table name (assuming it's 'filelists')
                            //->whereIn('master.file_list.is_file_admin_verified', [0,1])       // Correct table name (assuming it's 'filelists')
                            ->where('master.file_list.performa', 'LIKE', '%' . $type . '%')
                            ->where('uid', Session::get('Uid'));  // Correct the condition for 'uid'
                    })
                    //->when($isPoliceStaff == 'N', function ($query) {
                    ->when(User::where('id', Session::get('Uid'))->value('is_police_staff') == 'N', function ($query) {
                        // If user is not a police staff, exclude document_type = 8
                        return $query->whereNotIn('document_type', [8]);
                    })
                    // Conditionally add the exclusion for document type 8 based on the user's role fix pay staff
                    ->when(User::where('id', Session::get('Uid'))->value('is_fix_pay_staff') == 'N', function ($query) {
                        // Only apply this whereNotIn condition if the user is not a police staff
                        return $query->whereNotIn('document_type', [7]);  // Exclude document type 8
                    })
                    ->when(
                        // Add the condition to check if 'is_phy_dis' is 'Y' and 'dis_per' is less than 60, or if 'is_phy_dis' is 'N'
                        (User::where('id', Session::get('Uid'))->value('is_phy_dis') == 'Y' &&
                            User::where('id', Session::get('Uid'))->value('dis_per') <= 60) ||
                            User::where('id', Session::get('Uid'))->value('is_phy_dis') == 'N',
                        function ($query) {
                            // Exclude document type 9 for users who are either physically disabled with dis_per <= 60 or is_phy_dis == 'N'
                            return $query->whereNotIn('document_type', [9]);
                        }
                    )
                    ->count();
                // ->get();
                $doc_submitted = Filelist::where('request_id', $requestid)
                    //->whereNotIn('document_id', [2, 6, 9, 10, 3, 7])  // Exclude document types
                    ->whereNotIn('document_id', [6])
                    ->where('performa', 'a')
                    ->where('rivision_id', $rev)
                    ->whereIn('document_id', function ($query) use ($type) {
                        $query->select('document_id')  // Select the correct column (document_id)
                            ->from('master.file_list')
                            ->whereIn('master.file_list.is_file_ddo_verified', [2])       // Correct table name (assuming it's 'filelists')
                            //->whereIn('master.file_list.is_file_admin_verified', [0,1])       // Correct table name (assuming it's 'filelists')
                            ->where('master.file_list.performa', 'LIKE', '%' . $type . '%')
                            ->where('uid', Session::get('Uid'));  // Correct the condition for 'uid'
                    })
                    ->where('uid', Session::get('Uid'))
                    //->when($isPoliceStaff == 'N', function ($query) {
                    ->when(User::where('id', Session::get('Uid'))->value('is_police_staff') == 'N', function ($query) {
                        // If user is not a police staff, exclude document_type = 8
                        return $query->whereNotIn('document_id', [8]);
                    })
                    // Conditionally add the exclusion for document type 8 based on the user's role fix pay staff
                    ->when(User::where('id', Session::get('Uid'))->value('is_fix_pay_staff') == 'N', function ($query) {
                        // Only apply this whereNotIn condition if the user is not a police staff
                        return $query->whereNotIn('document_id', [7]);  // Exclude document type 8
                    })
                    ->when(
                        // Add the condition to check if 'is_phy_dis' is 'Y' and 'dis_per' is less than 60, or if 'is_phy_dis' is 'N'
                        (User::where('id', Session::get('Uid'))->value('is_phy_dis') == 'Y' &&
                            User::where('id', Session::get('Uid'))->value('dis_per') <= 60) ||
                            User::where('id', Session::get('Uid'))->value('is_phy_dis') == 'N',
                        function ($query) {
                            // Exclude document type 9 for users who are either physically disabled with dis_per <= 60 or is_phy_dis == 'N'
                            return $query->whereNotIn('document_id', [9]);
                        }
                    )->count();
            } else if ($ddo_remarks['ddo_remarks'] == '' && $admin_remarks['remarks'] != '') {
                $doc_tobe_submit = Documenttype::where('performa', 'like', '%a%')
                    ->whereNotIn('document_type', [6])  // Exclude document types
                    ->whereIn('document_type', function ($query) use ($type) {
                        $query->select('document_id')  // Select the correct column (document_id)
                            ->from('master.file_list')
                            //  ->whereIn('master.file_list.is_file_ddo_verified', [2])       // Correct table name (assuming it's 'filelists')
                            ->whereIn('master.file_list.is_file_admin_verified', [0, 2])       // Correct table name (assuming it's 'filelists')
                            ->where('master.file_list.performa', 'LIKE', '%' . $type . '%')
                            ->where('uid', Session::get('Uid'));  // Correct the condition for 'uid'
                    })
                    ->when(User::where('id', Session::get('Uid'))->value('is_police_staff') == 'N', function ($query) {
                        // If user is not a police staff, exclude document_type = 8
                        return $query->whereNotIn('document_type', [8]);
                    })
                    // Conditionally add the exclusion for document type 8 based on the user's role fix pay staff
                    ->when(User::where('id', Session::get('Uid'))->value('is_fix_pay_staff') == 'N', function ($query) {
                        // Only apply this whereNotIn condition if the user is not a police staff
                        return $query->whereNotIn('document_type', [7]);  // Exclude document type 8
                    })
                    ->when(
                        // Add the condition to check if 'is_phy_dis' is 'Y' and 'dis_per' is less than 60, or if 'is_phy_dis' is 'N'
                        (User::where('id', Session::get('Uid'))->value('is_phy_dis') == 'Y' &&
                            User::where('id', Session::get('Uid'))->value('dis_per') <= 60) ||
                            User::where('id', Session::get('Uid'))->value('is_phy_dis') == 'N',
                        function ($query) {
                            // Exclude document type 9 for users who are either physically disabled with dis_per <= 60 or is_phy_dis == 'N'
                            return $query->whereNotIn('document_type', [9]);
                        }
                    )
                    ->count();
                //  ->get();
                $doc_submitted = Filelist::where('request_id', $requestid)
                    ->whereNotIn('document_id', [6])
                    ->where('performa', 'a')
                    ->where('rivision_id', $rev)
                    ->whereIn('document_id', function ($query) use ($type) {
                        $query->select('document_id')  // Select the correct column (document_id)
                            ->from('master.file_list')
                            //  ->whereIn('master.file_list.is_file_ddo_verified', [2])       // Correct table name (assuming it's 'filelists')
                            ->whereIn('master.file_list.is_file_admin_verified', [0, 2])       // Correct table name (assuming it's 'filelists')
                            ->where('master.file_list.performa', 'LIKE', '%' . $type . '%')
                            ->where('uid', Session::get('Uid'));  // Correct the condition for 'uid'
                    })
                    ->where('uid', Session::get('Uid'))
                    ->when(User::where('id', Session::get('Uid'))->value('is_police_staff') == 'N', function ($query) {
                        // If user is not a police staff, exclude document_type = 8
                        return $query->whereNotIn('document_id', [8]);
                    })
                    // Conditionally add the exclusion for document type 8 based on the user's role fix pay staff
                    ->when(User::where('id', Session::get('Uid'))->value('is_fix_pay_staff') == 'N', function ($query) {
                        // Only apply this whereNotIn condition if the user is not a police staff
                        return $query->whereNotIn('document_id', [7]);  // Exclude document type 8
                    })
                    ->when(
                        // Add the condition to check if 'is_phy_dis' is 'Y' and 'dis_per' is less than 60, or if 'is_phy_dis' is 'N'
                        (User::where('id', Session::get('Uid'))->value('is_phy_dis') == 'Y' &&
                            User::where('id', Session::get('Uid'))->value('dis_per') <= 60) ||
                            User::where('id', Session::get('Uid'))->value('is_phy_dis') == 'N',
                        function ($query) {
                            // Exclude document type 9 for users who are either physically disabled with dis_per <= 60 or is_phy_dis == 'N'
                            return $query->whereNotIn('document_id', [9]);
                        }
                    )->count();
            }



            //    $lastQuery = DB::getQueryLog();
            //print_r($lastQuery);
            // Get the last query executed
            //$query = end($lastQuery);
            // dd($query);
            // dd("Document to be submit :- ".$doc_tobe_submit,'hii<br>',"Document submitted :- ".$doc_submitted);
            if ($doc_tobe_submit != $doc_submitted) { //dd("test");


                return redirect()->action('QuartersController@uploaddocument', [
                    'r' => base64_encode($requestid),
                    'type' => base64_encode($request->type),
                    'rev' => base64_encode($rev)
                ])->with('failed', 'Upload All Documents');
            }
            try {
                $inward_no = '';
                $uid = auth()->id(); // Example: Get user ID, adjust as needed
                $quartertype = $quartertype; // Define quarter type
                $downgrade_requestid = $downgrade_requestid; // Get from request

                while (true) {
                    $inward_no = generateRandomString(5);
                    $inward_no = "$quartertype/" . date('Y') . "/$uid/$inward_no";
                    $co = Tquarterrequesta::where('inward_no', $inward_no)->count();
                    if ($co == 0) break;
                }

                $data = [
                    'inward_no' => $inward_no,
                    'inward_date' => now(),
                    'is_accepted' => 1,
                    'is_priority' => 'N',
                    'is_ddo_varified' => 0,
                    'ddo_remarks' => null,
                    'is_varified' => 0,
                    'remarks' => null

                ];

                $resp = Tquarterrequesta::where('requestid', $request->input('requestid'))->update($data);

                // Downgrade Allotment
                if ($downgrade_requestid != "") {
                    $inward_no = '';
                    $downgrade_quartertype =  $downgrade_requestid; // Define downgrade quarter type

                    while (true) {
                        $inward_no = generateRandomString(5);
                        $inward_no = "$downgrade_quartertype/" . date('Y') . "/$uid/$inward_no";
                        $co = Tquarterrequesta::where('inward_no', $inward_no)->count();
                        if ($co == 0) break;
                    }

                    $data = [
                        'inward_no' => $inward_no,
                        'inward_date' => now(),
                        'is_accepted' => 1,
                        'is_priority' => 'N',
                    ];

                    $respdgr = Tquarterrequesta::where('requestid', $downgrade_requestid)->update($data);
                }

                if ($resp) {
                    return redirect()->route('user.quarter.history')->with('smsg', 'Request Submitted Successfully');
                } else {
                    $errorMessage = 'Please attach all requested documents then submit your request.';
                    return redirect()->action('QuartersController@uploaddocument', [
                        'r' => base64_encode($requestId),
                        'type' => base64_encode($type),
                        'rev' => base64_encode($rev)
                    ])->with('error', $errorMessage);
                }
            } catch (\Exception $pe) {
                //dd($pe->getMessage());
                // Construct the URL
                $errorMessage = 'Please attach all requested documents then submit your request.';
                return redirect()->action('QuartersController@uploaddocument', [
                    'r' => base64_encode($requestid),
                    'type' => base64_encode($request->type),
                    'rev' => base64_encode($rev)
                ])->with('error', $errorMessage);
            }
        }
        if ($request->type == 'b') {
            //dd(Session::get('Uid'));
            $result = Tquarterrequestb::where('requestid', $requestid)
                ->first();
            if ($downgrade_requestid != "") {
                $downgrade_request = Tquarterrequestb::where('requestid', $requestid)
                    ->first();
                $downgrade_quartertype = $downgrade_request->quartertype;
            }

            $quartertype = $result->quartertype;

            // Get user data for is_police_staff
            $isPoliceStaff = User::where('id', Session::get('Uid'))->value('is_police_staff');
            $isFixPayStaff = User::where('id', Session::get('Uid'))->value('is_fix_pay_staff');

            // Count documents where 'performa' contains 'a'
            //$doc_tobe_submit = Documenttype::where('performa', 'like', '%a%')->whereNotIn('document_type', [2, 6, 9, 10,3,7])->count();
            $type = 'b';
            if ($ddo_remarks['ddo_remarks'] == '' && $admin_remarks['remarks'] == '' && $wno['wno'] == '') {

                $doc_tobe_submit = Documenttype::where('performa', 'like', '%b%')
                    ->whereNotIn('document_type', [6])  // Exclude document types
                    //     ->whereNotIn('document_type', function ($query) use($type) {
                    //     $query->select('document_id')  // Select the correct column (document_id)
                    //         ->from('master.file_list')  
                    //         ->whereIn('master.file_list.is_file_ddo_verified', [0,1])       // Correct table name (assuming it's 'filelists')
                    //         ->whereIn('master.file_list.is_file_admin_verified', [0,1])       // Correct table name (assuming it's 'filelists')
                    //         ->where('master.file_list.performa', 'LIKE', '%' . $type . '%')
                    //         ->where('uid', Session::get('Uid'));  // Correct the condition for 'uid'
                    // })
                    ->when(User::where('id', Session::get('Uid'))->value('is_police_staff') == 'N', function ($query) {
                        // If user is not a police staff, exclude document_type = 8
                        return $query->whereNotIn('document_type', [8]);
                    })
                    // Conditionally add the exclusion for document type 8 based on the user's role fix pay staff
                    ->when(User::where('id', Session::get('Uid'))->value('is_fix_pay_staff') == 'N', function ($query) {
                        // Only apply this whereNotIn condition if the user is not a police staff
                        return $query->whereNotIn('document_type', [7]);  // Exclude document type 8
                    })
                    ->when(
                        // Add the condition to check if 'is_phy_dis' is 'Y' and 'dis_per' is less than 60, or if 'is_phy_dis' is 'N'
                        (User::where('id', Session::get('Uid'))->value('is_phy_dis') == 'Y' &&
                            User::where('id', Session::get('Uid'))->value('dis_per') <= 60) ||
                            User::where('id', Session::get('Uid'))->value('is_phy_dis') == 'N',
                        function ($query) {
                            // Exclude document type 9 for users who are either physically disabled with dis_per <= 60 or is_phy_dis == 'N'
                            return $query->whereNotIn('document_type', [9]);
                        }
                    )
                    ->count();
                // ->get();
                $doc_submitted = Filelist::where('request_id', $requestid)

                    ->whereNotIn('document_id', [6])
                    ->where('performa', 'b')
                    ->where('rivision_id', $rev)
                    ->where('uid', Session::get('Uid'))
                    ->when(User::where('id', Session::get('Uid'))->value('is_police_staff') == 'N', function ($query) {
                        // If user is not a police staff, exclude document_type = 8
                        return $query->whereNotIn('document_id', [8]);
                    })
                    // Conditionally add the exclusion for document type 8 based on the user's role fix pay staff
                    ->when(User::where('id', Session::get('Uid'))->value('is_fix_pay_staff') == 'N', function ($query) {
                        // Only apply this whereNotIn condition if the user is not a police staff
                        return $query->whereNotIn('document_id', [7]);  // Exclude document type 8
                    })
                    ->when(
                        // Add the condition to check if 'is_phy_dis' is 'Y' and 'dis_per' is less than 60, or if 'is_phy_dis' is 'N'
                        (User::where('id', Session::get('Uid'))->value('is_phy_dis') == 'Y' &&
                            User::where('id', Session::get('Uid'))->value('dis_per') <= 60) ||
                            User::where('id', Session::get('Uid'))->value('is_phy_dis') == 'N',
                        function ($query) {
                            // Exclude document type 9 for users who are either physically disabled with dis_per <= 60 or is_phy_dis == 'N'
                            return $query->whereNotIn('document_id', [9]);
                        }
                    )->count();
            } else if ($ddo_remarks['ddo_remarks'] != '' && $admin_remarks['remarks'] == '') {

                $doc_tobe_submit = Documenttype::where('performa', 'like', '%b%')
                    ->whereNotIn('document_type', [6])  // Exclude document types
                    ->whereIn('document_type', function ($query) use ($type) {
                        $query->select('document_id')  // Select the correct column (document_id)
                            ->from('master.file_list')
                            ->whereIn('master.file_list.is_file_ddo_verified', [2])       // Correct table name (assuming it's 'filelists')
                            //->whereIn('master.file_list.is_file_admin_verified', [0,1])       // Correct table name (assuming it's 'filelists')
                            ->where('master.file_list.performa', 'LIKE', '%' . $type . '%')
                            ->where('uid', Session::get('Uid'));  // Correct the condition for 'uid'
                    })
                    ->when(User::where('id', Session::get('Uid'))->value('is_police_staff') == 'N', function ($query) {
                        // If user is not a police staff, exclude document_type = 8
                        return $query->whereNotIn('document_type', [8]);
                    })
                    // Conditionally add the exclusion for document type 8 based on the user's role fix pay staff
                    ->when(User::where('id', Session::get('Uid'))->value('is_fix_pay_staff') == 'N', function ($query) {
                        // Only apply this whereNotIn condition if the user is not a police staff
                        return $query->whereNotIn('document_type', [7]);  // Exclude document type 8
                    })
                    ->when(
                        // Add the condition to check if 'is_phy_dis' is 'Y' and 'dis_per' is less than 60, or if 'is_phy_dis' is 'N'
                        (User::where('id', Session::get('Uid'))->value('is_phy_dis') == 'Y' &&
                            User::where('id', Session::get('Uid'))->value('dis_per') <= 60) ||
                            User::where('id', Session::get('Uid'))->value('is_phy_dis') == 'N',
                        function ($query) {
                            // Exclude document type 9 for users who are either physically disabled with dis_per <= 60 or is_phy_dis == 'N'
                            return $query->whereNotIn('document_type', [9]);
                        }
                    )
                    ->count();

                $doc_submitted = Filelist::where('request_id', $requestid)
                    ->whereNotIn('document_id', [6])
                    ->where('performa', 'b')
                    ->where('rivision_id', $rev)
                    ->whereIn('document_id', function ($query) use ($type) {
                        $query->select('document_id')  // Select the correct column (document_id)
                            ->from('master.file_list')
                            ->whereIn('master.file_list.is_file_ddo_verified', [2])       // Correct table name (assuming it's 'filelists')
                            //->whereIn('master.file_list.is_file_admin_verified', [0,1])       // Correct table name (assuming it's 'filelists')
                            ->where('master.file_list.performa', 'LIKE', '%' . $type . '%')
                            ->where('uid', Session::get('Uid'));  // Correct the condition for 'uid'
                    })
                    ->where('uid', Session::get('Uid'))
                    ->when(User::where('id', Session::get('Uid'))->value('is_police_staff') == 'N', function ($query) {
                        // If user is not a police staff, exclude document_type = 8
                        return $query->whereNotIn('document_id', [8]);
                    })
                    // Conditionally add the exclusion for document type 8 based on the user's role fix pay staff
                    ->when(User::where('id', Session::get('Uid'))->value('is_fix_pay_staff') == 'N', function ($query) {
                        // Only apply this whereNotIn condition if the user is not a police staff
                        return $query->whereNotIn('document_id', [7]);  // Exclude document type 8
                    })
                    ->when(
                        // Add the condition to check if 'is_phy_dis' is 'Y' and 'dis_per' is less than 60, or if 'is_phy_dis' is 'N'
                        (User::where('id', Session::get('Uid'))->value('is_phy_dis') == 'Y' &&
                            User::where('id', Session::get('Uid'))->value('dis_per') <= 60) ||
                            User::where('id', Session::get('Uid'))->value('is_phy_dis') == 'N',
                        function ($query) {
                            // Exclude document type 9 for users who are either physically disabled with dis_per <= 60 or is_phy_dis == 'N'
                            return $query->whereNotIn('document_id', [9]);
                        }
                    )->count();
            } else if ($ddo_remarks['ddo_remarks'] == '' && $admin_remarks['remarks'] != '') {
                $doc_tobe_submit = Documenttype::where('performa', 'like', '%b%')
                    ->whereNotIn('document_type', [6])  // Exclude document types
                    ->whereIn('document_type', function ($query) use ($type) {
                        $query->select('document_id')  // Select the correct column (document_id)
                            ->from('master.file_list')
                            //  ->whereIn('master.file_list.is_file_ddo_verified', [2])       // Correct table name (assuming it's 'filelists')
                            ->whereIn('master.file_list.is_file_admin_verified', [0, 2])       // Correct table name (assuming it's 'filelists')
                            ->where('master.file_list.performa', 'LIKE', '%' . $type . '%')
                            ->where('uid', Session::get('Uid'));  // Correct the condition for 'uid'
                    })
                    ->when(User::where('id', Session::get('Uid'))->value('is_police_staff') == 'N', function ($query) {
                        // If user is not a police staff, exclude document_type = 8
                        return $query->whereNotIn('document_type', [8]);
                    })
                    // Conditionally add the exclusion for document type 8 based on the user's role fix pay staff
                    ->when(User::where('id', Session::get('Uid'))->value('is_fix_pay_staff') == 'N', function ($query) {
                        // Only apply this whereNotIn condition if the user is not a police staff
                        return $query->whereNotIn('document_type', [7]);  // Exclude document type 8
                    })
                    ->when(
                        // Add the condition to check if 'is_phy_dis' is 'Y' and 'dis_per' is less than 60, or if 'is_phy_dis' is 'N'
                        (User::where('id', Session::get('Uid'))->value('is_phy_dis') == 'Y' &&
                            User::where('id', Session::get('Uid'))->value('dis_per') <= 60) ||
                            User::where('id', Session::get('Uid'))->value('is_phy_dis') == 'N',
                        function ($query) {
                            // Exclude document type 9 for users who are either physically disabled with dis_per <= 60 or is_phy_dis == 'N'
                            return $query->whereNotIn('document_type', [9]);
                        }
                    )
                    ->count();
                //  ->get();
                $doc_submitted = Filelist::where('request_id', $requestid)
                    ->whereNotIn('document_id', [6])
                    ->where('performa', 'b')
                    ->where('rivision_id', $rev)
                    ->whereIn('document_id', function ($query) use ($type) {
                        $query->select('document_id')  // Select the correct column (document_id)
                            ->from('master.file_list')
                            //  ->whereIn('master.file_list.is_file_ddo_verified', [2])       // Correct table name (assuming it's 'filelists')
                            ->whereIn('master.file_list.is_file_admin_verified', [0, 2])       // Correct table name (assuming it's 'filelists')
                            ->where('master.file_list.performa', 'LIKE', '%' . $type . '%')
                            ->where('uid', Session::get('Uid'));  // Correct the condition for 'uid'
                    })
                    ->where('uid', Session::get('Uid'))
                    ->when(User::where('id', Session::get('Uid'))->value('is_police_staff') == 'N', function ($query) {
                        // If user is not a police staff, exclude document_type = 8
                        return $query->whereNotIn('document_id', [8]);
                    })
                    // Conditionally add the exclusion for document type 8 based on the user's role fix pay staff
                    ->when(User::where('id', Session::get('Uid'))->value('is_fix_pay_staff') == 'N', function ($query) {
                        // Only apply this whereNotIn condition if the user is not a police staff
                        return $query->whereNotIn('document_id', [7]);  // Exclude document type 8
                    })
                    ->when(
                        // Add the condition to check if 'is_phy_dis' is 'Y' and 'dis_per' is less than 60, or if 'is_phy_dis' is 'N'
                        (User::where('id', Session::get('Uid'))->value('is_phy_dis') == 'Y' &&
                            User::where('id', Session::get('Uid'))->value('dis_per') <= 60) ||
                            User::where('id', Session::get('Uid'))->value('is_phy_dis') == 'N',
                        function ($query) {
                            // Exclude document type 9 for users who are either physically disabled with dis_per <= 60 or is_phy_dis == 'N'
                            return $query->whereNotIn('document_id', [9]);
                        }
                    )->count();
            }



            $lastQuery = DB::getQueryLog();
            //print_r($lastQuery);
            // Get the last query executed
            //   $query = end($lastQuery);
            // dd($query);
            //    dd("Document to be submit :- ".$doc_tobe_submit,'hii<br>',"Document submitted :- ".$doc_submitted);

            if ($doc_tobe_submit != $doc_submitted) { //dd("test");


                return redirect()->action('QuartersController@uploaddocument', [
                    'r' => base64_encode($requestid),
                    'type' => base64_encode($request->type),
                    'rev' => base64_encode($rev)
                ])->with('failed', 'Upload All Documents');
            }
            try {
                $inward_no = '';
                $uid = auth()->id(); // Example: Get user ID, adjust as needed
                $quartertype = $quartertype; // Define quarter type
                $downgrade_requestid = $downgrade_requestid; // Get from request

                while (true) {
                    $inward_no = generateRandomString(5);
                    $inward_no = "$quartertype/" . date('Y') . "/$uid/$inward_no";
                    $co = Tquarterrequestb::where('inward_no', $inward_no)->count();
                    if ($co == 0) break;
                }

                $data = [
                    'inward_no' => $inward_no,
                    'inward_date' => now(),
                    'is_accepted' => 1,
                    'is_priority' => 'N',
                    'is_ddo_varified' => 0,
                    'ddo_remarks' => null,
                    'is_varified' => 0,
                    'remarks' => null
                ];


                $resp = Tquarterrequestb::where('requestid', $request->input('requestid'))->update($data);

                // Downgrade Allotment
                if ($downgrade_requestid != "") {
                    $inward_no = '';
                    $downgrade_quartertype =  $downgrade_requestid; // Define downgrade quarter type

                    while (true) {
                        $inward_no = generateRandomString(5);
                        $inward_no = "$downgrade_quartertype/" . date('Y') . "/$uid/$inward_no";
                        $co = Tquarterrequestb::where('inward_no', $inward_no)->count();
                        if ($co == 0) break;
                    }

                    $data = [
                        'inward_no' => $inward_no,
                        'inward_date' => now(),
                        'is_accepted' => 1,
                        'is_priority' => 'N',
                    ];

                    $respdgr = Tquarterrequestb::where('requestid', $downgrade_requestid)->update($data);
                }

                if ($resp) {
                    return redirect()->route('user.quarter.history')->with('smsg', 'Request Submitted Successfully');
                } else {
                    $errorMessage = 'Please attach all requested documents then submit your request.';
                    return redirect()->action('QuartersController@uploaddocument', [
                        'r' => base64_encode($requestId),
                        'type' => base64_encode($type),
                        'rev' => base64_encode($rev)
                    ])->with('error', $errorMessage);
                }
            } catch (\Exception $pe) {
                //   dd($pe->getMessage());
                // Construct the URL
                $errorMessage = 'Please attach all requested documents then submit your request.';
                return redirect()->action('QuartersController@uploaddocument', [
                    'r' => base64_encode($requestid),
                    'type' => base64_encode($request->type),
                    'rev' => base64_encode($rev)
                ])->with('error', $errorMessage);
            }
        }
       
    }
    
public function getUserWithdrawDetails(Request $request)
{
    $validated = $request->validate([
        'withdraw_remarks' => 'required|string|max:1000',
        'agree_rules' => 'required|accepted',
    ]);

    DB::beginTransaction();

    try {
        $requestid = base64_decode($request->input('requestid'));
        $performa = strip_tags($request->input('performa'));
        $uid = Session::get('Uid');
        $wait_no = (int) $request->input('wait_no');
        $withdraw_remarks = strip_tags($request->input('withdraw_remarks'));
        $quartertype = strip_tags($request->input('quartertype'));

        // Withdraw logic
        $targetTable = $performa === 'New'
            ? 'master.t_quarter_request_a'
            : 'master.t_quarter_request_b';

        DB::table($targetTable)
            ->where('requestid', $requestid)
            ->where('wno', $wait_no)
            ->where('uid', $uid)
            ->update([
                'r_wno' => null,
                'withdraw_remarks' => $withdraw_remarks,
                'is_withdraw' => 'Y',
            ]);

        // Clear r_wno for re-ranking
        foreach (['a', 'b'] as $type) {
            $table = $type === 'a' ? 'master.t_quarter_request_a' : 'master.t_quarter_request_b';
            DB::table($table)
                ->where('quartertype', $quartertype)
                ->where('is_priority', 'N')
                ->whereNotNull('wno')
                ->update(['r_wno' => null]);
        }

        // Fetch pending applications
        $applications = DB::table('master.t_quarter_request_a')
            ->select('wno', 'uid', 'office_remarks')
            ->where('quartertype', $quartertype)
            ->where('is_priority', 'N')
            ->whereNotNull('wno')
            ->where('is_withdraw', 'N')
            ->whereNull('office_remarks')
            ->whereNull('withdraw_remarks')
            ->unionAll(
                DB::table('master.t_quarter_request_b')
                    ->select('wno', 'uid', 'office_remarks')
                    ->where('quartertype', $quartertype)
                    ->where('is_priority', 'N')
                    ->whereNotNull('wno')
                    ->where('is_withdraw', 'N')
                    ->whereNull('office_remarks')
                    ->whereNull('withdraw_remarks')
            )
            ->orderBy('wno')
            ->get();

        foreach ($applications as $re) {
            $appUid = $re->uid;
            $today = now()->toDateString();

            $isRetired = DB::table('userschema.users')
                ->where('id', $appUid)
                ->where('date_of_retirement', '<', $today)
                ->exists();

            if ($isRetired) {
                foreach (['a', 'b'] as $type) {
                    $table = $type === 'a' ? 'master.t_quarter_request_a' : 'master.t_quarter_request_b';

                    DB::table($table)
                        ->where('quartertype', $quartertype)
                        ->where('uid', $appUid)
                        ->where('is_priority', 'N')
                        ->whereNotNull('wno')
                        ->update(['r_wno' => null]);

                    Log::info("Retired UID $appUid reset r_wno in table $table");
                }
            } else {
                $maxA = DB::table('master.t_quarter_request_a')
                    ->where('quartertype', $quartertype)
                    ->where('is_priority', 'N')
                    ->whereNotNull('wno')
                    ->max('r_wno');

                $maxB = DB::table('master.t_quarter_request_b')
                    ->where('quartertype', $quartertype)
                    ->where('is_priority', 'N')
                    ->whereNotNull('wno')
                    ->max('r_wno');

                $new_r_wno = max((int) $maxA, (int) $maxB) + 1;

                foreach (['a', 'b'] as $type) {
                    $table = $type === 'a' ? 'master.t_quarter_request_a' : 'master.t_quarter_request_b';

                    DB::table($table)
                        ->where('quartertype', $quartertype)
                        ->where('wno', $re->wno)
                        ->where('is_priority', 'N')
                        ->whereNotNull('wno')
                        ->update(['r_wno' => $new_r_wno]);

                    Log::info("UID {$re->uid} updated r_wno={$new_r_wno} in $table");
                }
            }
        }

        DB::commit();
        return response()->json(['status' => 'success', 'message' => 'Application withdrawn successfully.']);
    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Withdraw error: ' . $e->getMessage());
        return response()->json(['status' => 'error', 'message' => 'Something went wrong.']);
    }
}

}