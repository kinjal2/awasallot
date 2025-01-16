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
use App\QuarterAllotment;
use Carbon\Carbon;
use Session;
use Yajra\Datatables\Datatables;
use DB;
use Mpdf\Mpdf;
use Mpdf\Config\ConfigVariables;
use Mpdf\Config\FontVariables;
use App\Couchdb\Couchdb;

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
        $this->_viewContent['page_title'] = "Quarter History";
        return view('user/historyQuarter', $this->_viewContent);
    }
    public function requestnewquarter()
    {

        $uid = Session::get('Uid');
        $basic_pay = Session::get('basic_pay');  //dd($basic_pay);
        $q_officecode = Session::get('q_officecode');
        if ($basic_pay == null) {
            return redirect('profile')->with('message', "Please complete your profile.");
        }
        //$quarterselect = Quarter::where('bpay_from', '<=', $basic_pay)->where('bpay_to', '>=', $basic_pay)->get();
        $quarterselect = Quarter::where('bpay_from', '<=', $basic_pay)->where('bpay_to', '>=', $basic_pay)->where('officecode', $q_officecode)->get();
        $quarterrequesta = Tquarterrequesta::where('uid', '=', $uid)->where('quartertype', '=', $quarterselect[0]->quartertype)->get();
        $quarterrequestcheck = $quarterrequesta->count();
        if ($quarterrequestcheck > 0) {
            return redirect('userdashboard')->with('message', "You have been registered for a new quarter request.");
        } else {
            $this->_viewContent['page_title'] = "Quarter Request";
            return view('user/newQuarterRequest', $this->_viewContent);
        }
    }
    public function requesthighercategory()
    {
        $uid = Session::get('Uid');
        $basic_pay = Session::get('basic_pay');
        $q_officecode = Session::get('q_officecode');
        if ($basic_pay == null) {
            return redirect('profile')->with('failed', "Please complete your profile.");
        }
        //$quarterselect = Quarter::where('bpay_from', '<=', $basic_pay)->where('bpay_to', '>=', $basic_pay)->get();
        $quarterselect = Quarter::where('bpay_from', '<=', $basic_pay)->where('bpay_to', '>=', $basic_pay)->where('officecode', $q_officecode)->get();
        $quarterrequesta = Tquarterrequestb::where('uid', '=', $uid)->where('quartertype', '=', $quarterselect[0]->quartertype)->get();
        $quarterrequestcheck = $quarterrequesta->count();
        // dd($quarterrequestcheck);
        if ($quarterrequestcheck > 0) {
            return redirect('userdashboard')->with('message', "You have been registered for a higher category quarter request.");
        } else {
            $this->_viewContent['page_title'] = "Higher Category";
            return view('user/higherCategoryQuarterRequest', $this->_viewContent);
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
                $Tquarterrequestb->is_accepted = empty($request->get('agree_rules')) ? 0 : 1;
                $Tquarterrequestb->request_date = date('Y-m-d');
                $Tquarterrequestb->save();
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
            /*'deputation_date' => 'required',
            'old_desg' => 'required',
            'deputation_yn' => 'required',
            'old_office' => 'required',
            'prv_rent' => 'required',
            'prv_building_no' => 'required',
            'old_allocation_yn' => 'required',
            'prv_quarter_type' => 'required',
            'prv_handover' => 'required',
            'prv_area_name'=>'required',
            'have_old_quarter_yn'=>'required',
            'is_relative_yn' => 'required',
            'relative_details' => 'required',
            'is_stsc_yn'=>'required',
            'scst_details'=>'required',
            'is_relative_house_yn' => 'required',
            'relative_house_details' => 'required',
            'have_house_nearby_yn'=>'required',
            'nearby_house_details'=>'required',
            'downgrade_allotment' => 'required',
            'agree_rules'=>'required',


            'agree_rules'=>'required', */
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect('quartersuser')
                ->withInput()
                ->withErrors($validator);
        } else {
            $data = $request->input();
            //  dd($data);
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
                $Tquarterrequesta->save();
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
        //dd($uid,$basic_pay);
        $quarterselect = Quarter::where('bpay_from', '<=', $basic_pay)->where('bpay_to', '>=', $basic_pay)->get();
        // DB::enableQueryLog();
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
            'rivision_id'
        ])
            ->where('is_allotted', '=', 0)
            ->where('uid', '=', $uid)
            ->whereNotNull('request_date')
            ->where('quartertype', '=', ($quarterselect[0]->quartertype));
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
            'rivision_id'
        ])
            ->where('quartertype', '=', ($quarterselect[0]->quartertype))
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
            'rivision_id'
        ])
            ->where('quartertype', '=', ($quarterselect[0]->quartertype))
            ->where('is_allotted', '=', 0)
            ->whereNotNull('request_date')
            ->where('uid', '=', $uid)
            ->union($quarterlist)
            ->union($quarterlist2)
            ->get();
      

        return Datatables::of($quarterlist3)
            ->addIndexColumn()
            ->addColumn('inward_no', function ($row) {
                if ($row->inward_no == '') return 'N/A';

                return $row->inward_no;
            })
            ->addColumn('inward_date', function ($inward_date) {
                if ($inward_date->inward_date == '')  return 'N/A';
                $inward_date = Carbon::parse($inward_date->inward_date);
                return $inward_date->format('d-m-Y');
            })
            ->addColumn('request_date', function ($request_date) {
                if ($request_date->request_date == '')  return 'N/A';
                $request_date = Carbon::parse($request_date->request_date);
                return $request_date->format('d-m-Y');;
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
                ]) . '" class="btn btn-primary btn-sm">
        <i class="fa fa-print"></i>
    </a>' . "&nbsp;";

                // Conditional check for the upload button
                if ($row->inward_no == '') { // Replace with your own condition
                    $btn1 .= '<a href="' . \URL::action('QuartersController@uploaddocument') .
                        "?r=" . base64_encode($row->requestid) .
                        "&type=" . base64_encode($row->type) .
                        "&rev=" . base64_encode($row->rivision_id) .
                        '" class="btn btn-primary btn-sm">
                <i class="fa fa-upload" aria-hidden="true" alt="Upload Documents"></i>
            </a>';
                }

                // Return the generated buttons
                return $btn1;
            })

            ->rawColumns(['action'])

            ->make(true);
    }
    public function generate_pdf($request_id, $revision_id, $performa)
    {       // Decode the query parameters if necessary
        $uid = Session::get('Uid');
        $requestid = base64_decode($request_id);
        $type = base64_decode($performa);
        $rivision_id = base64_decode($revision_id);
        $requestModel = new TQuarterRequesta();
        $data = $requestModel->getFormattedRequestData($requestid, $rivision_id);
        $imageData = generateImage($uid);
        // Assign the image data to the data array to be passed to the view
        $data['imageData'] = $imageData;
        $officecode=Session::get('officecode');
        $officecode = getOfficeByCode($officecode);
        $data['officesname'] = isset($officecode[0]->officesnameguj) ? $officecode[0]->officesnameguj : null;

       
		//dd( $data);
        try {
            // Define the path to the font directory
            $fontDir = __DIR__ . '/vendor/mpdf/mpdf/ttfonts';

            // Custom font configuration
            $defaultConfig = (new ConfigVariables())->getDefaults();
            $fontDirs = $defaultConfig['fontDir'];

            $defaultFontConfig = (new FontVariables())->getDefaults();
            $fontData = $defaultFontConfig['fontdata'];
    
            // Adding custom font directory and font data
            $fontDirs = array_merge($fontDirs, [$fontDir]);
            $fontData = $fontData + [
                'ind_gu_1_001' => [
                    'R' => 'ind_gu_1_001.ttf'
                ]
            ];

            // Pass the updated font settings to mPDF
            $mpdf = new Mpdf([
                'fontDir' => $fontDirs,
                'fontdata' => $fontData,
                'default_font' => 'ind_gu_1_001'
            ]);

            // Enable auto language and font settings
            $mpdf->autoScriptToLang = true;
            $mpdf->autoLangToFont = true;
            //dd($data);
            // Load HTML view and render it
            $html = view('request/applicationview', $data)->render();

            // Write HTML to PDF
            $mpdf->WriteHTML($html);

            // Output PDF to browser
           
            $filename = "application_from_{$uid}_" . time() . ".pdf";  // Dynamic filename based on user ID and timestamp
            $mpdf->Output($filename,'I');
        } catch (\Mpdf\MpdfException $e) {
            echo $e->getMessage();
        }
    }
    public function uploaddocument()
    {

        $request_id = base64_decode($_REQUEST['r']);
        $type = base64_decode($_REQUEST['type']);
        $rev = base64_decode($_REQUEST['rev']);
       
        $document_list = Documenttype::where('performa', 'LIKE', '%' . $type . '%')
            ->whereNotIn('document_type', [2, 6, 9, 10,3,7])
            ->whereNotIn('document_type',  Filelist::WHERE('uid', Session::get('Uid'))
                ->WHERE('request_id', $request_id)->WHERE('performa', $type)
                ->pluck('document_id'))
            ->pluck('document_name', 'document_type');

        //$lastQuery = DB::getQueryLog();
        //$query = end($lastQuery); // Get the last query

        // Print the SQL query and bindings
        //dd($query);
        // dd( $document_list);
        $attacheddocument = DB::table('master.file_list')
            ->join('master.m_document_type', 'master.file_list.document_id', '=', 'master.m_document_type.document_type')
            ->WHERE('uid', Session::get('Uid'))
            ->WHERE('request_id', $request_id)
            ->WHERE('master.file_list.performa', 'LIKE', '%' . $type . '%')
            ->select('rev_id', 'doc_id', 'document_name')
            ->get();
        //dd( $attacheddocument );
        $this->_viewContent['page_title'] = "Upload Document";
        $this->_viewContent['document_list'] = $document_list;
        $this->_viewContent['attacheddocument'] = $attacheddocument;
        $this->_viewContent['request_id'] = $request_id;
        $this->_viewContent['rev'] = $rev;
        $this->_viewContent['type'] = $type;
        //dd($this->_viewContent);
        return view('user/documentupload', $this->_viewContent);
    }
    public function saveuploaddocument(request $request)
    {
        $docId = (string)Session::get('Uid') . "_" . base64_decode($request->request_id) . "_" . $request->document_type . "_" . base64_decode($request->perfoma) . "_" . base64_decode($request->request_rev);
        uploadDocuments($docId, $request->file('image'));
        return redirect()->back();
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
            //\Log::debug('Raw Document Response: ' . $doc);
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
    public function getNormalquarterListbackup_1_10_2024(request $request)
    {
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
            'is_priority'
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
            'is_priority'
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
            'is_priority'
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
                'is_priority'

            ])
            ->where(function ($query) {
                $query->where('is_accepted', '=', 1)
                    ->whereNull('remarks')
                    ->where('is_varified', '=', 0)
                    ->where('is_priority', '=', 'N')
                    ->orderBy('wno'); // assuming 'wno' is a column in the database
            });

        // Print the SQL query
        //echo $query->toSql();


        return Datatables::of($query)
            ->addColumn('inward_date', function ($date) {
                if ($date->inward_date == '')  return 'N/A';

                return date('d-m-Y', strtotime($date->inward_date));
            })
            ->addColumn('request_date', function ($date) {
                if ($date->request_date == '')  return 'N/A';

                return date('d-m-Y', strtotime($date->request_date));
            })

            ->addColumn('action', function ($row) {
                //  $btn1 =   "edit";
                if ($row->requesttype == 'New') {
                    //  $btn1 = '<a href="'.\route('editquarter', $row->requestid).'" class="btn btn-success "><i class="fas fa-edit"></i></a> ';
                    $btn1 = '<a href="' . \route('editquarter_a', ['r' => base64_encode($row->requestid), 'rv' => base64_encode($row->rivision_id)]) . '" class="btn btn-success "><i class="fas fa-edit"></i></a>';
                } else {
                    $btn1 = '<a href="' . \route('editquarter_b', ['r' => base64_encode($row->requestid), 'rv' => base64_encode($row->rivision_id)]) . '" class="btn btn-success "><i class="fas fa-edit"></i></a>';
                }
                return $btn1;
            })
            /* ->addColumn('delete', function($row){
         $btn1 ='<a href="' . \URL::action('QuartersController@uploaddocument'). "?r=" . base64_encode($row->requestid)."&type=". base64_encode($row->type)."&rev=". base64_encode($row->rivision_id).'" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>';
         return $btn1;
     })*/
            ->rawColumns(['delete', 'action'])
            ->make(true);
    }
    public function quarterNewRequest()
    {
        $this->_viewContent['page_title'] = "Quarter Request Details";
        return view('request/newQuarterRequest', $this->_viewContent);
    }
    public function editquarter_a_old(request $request, $requestid, $rv)
    {

        $requestid = base64_decode($requestid);
        $rivision_id = base64_decode($rivision_id);

        $requestModel = new TQuarterRequesta();
        $quarterrequest = $requestModel->getFormattedRequestData($requestid, $rivision_id);


        $this->_viewContent['file_uploaded'] = Filelist::select(['document_id', 'rev_id', 'doc_id', 'document_name'])
            ->join('master.m_document_type as  d', 'd.document_type', '=', 'master.Filelist.document_id')
            ->where('request_id', '=', $requestid)
            ->get();


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
    public function editquarter_a(request $request, $requestid, $rivision_id)
    {

        $requestid = base64_decode($requestid);
        $rivision_id = base64_decode($rivision_id);

        $requestModel = new TQuarterRequesta();
        $quarterrequest = $requestModel->getFormattedRequestData($requestid, $rivision_id);


        $this->_viewContent['file_uploaded'] = Filelist::select(['document_id', 'rev_id', 'doc_id', 'document_name'])
            ->join('master.m_document_type as  d', 'd.document_type', '=', 'master.file_list.document_id')
            ->where('request_id', '=', $requestid)
            ->get();


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
    public function editquarter_b(request $request, $requestid, $rivision_id)
    {
        // dd($requestid, $rv);
        $requestid = base64_decode($requestid);
        $rivision_id = base64_decode($rivision_id);
        $requestModel = new TQuarterRequestb();
        $quarterrequest = $requestModel->getFormattedRequestData($requestid, $rivision_id);


        $this->_viewContent['file_uploaded'] = Filelist::select(['document_id', 'rev_id', 'doc_id', 'document_name'])
            ->join('master.m_document_type as  d', 'd.document_type', '=', 'master.file_list.document_id')
            ->where('request_id', '=', $requestid)
            ->where('rivision_id', '=', $rivision_id)
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
          // dd( $request);
            $status=$request->status;
            $requestid=$request->requestid;
            $dg_allotment=$request->dg_allotment;
            $rv= $request->rv;
            $dg_request_id = TQuarterRequestA::orderBy('requestid', 'DESC')->value('requestid');
            $dg_request_id += 1;
            //get data using request and revision id
           $result=Tquarterrequesta::where('requestid',$requestid)
           ->where('rivision_id',$rv)
           ->first() ;
         //  print_r( $result);
           if ($status != 0) {
            try {

                $quarterTypeInstance = new QuarterType();
                $wno = $quarterTypeInstance->getNextWno( $result->quartertype);
              // echo $wno; exit;

                // Retrieve r_wno value
                $rWnoA = TQuarterRequestA::getMaxRwno($result->quartertype);
                $rWnoB = TQuarterRequestB::getMaxRwno($result->quartertype);
                $rWno = max($rWnoA, $rWnoB) + 1;
                // Update the TQuarterRequestA record
                TQuarterRequestA::where('requestid', $requestid)
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

            if ($dg_allotment == 'Y') {
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

                        $quarterTypeInstance = new QuarterType();
                       $dg_wno = $quarterTypeInstance->calculateDgWno($dgQuartertype);

                    // Create and save a new TQuarterRequestA instance
                    $requestModel = TQuarterRequestA::create([
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
                        'request_date' => now(), // Using Laravels helper function to  the current date and time
                        'is_downgrade_request' => 1,
                        'is_priority' => 'N',
                        'reference_id' => $result->requestid,
                        'dg_rivision_id' => $result->rivision_id,
                        'is_varified' => 1,
                        'is_accepted' => 1,
                        'remarks' => '',
                        'updatedBy' => $result->uid,
                        'Wno' => $dg_wno
                    ]);

                    // Update Dgrid in TQuarterRequestA
                    TQuarterRequestA::where('requestid', $requestid)
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


        }
         else
            {
                $result=Tquarterrequesta::where('requestid',$requestid)->where('rivision_id',$rv)
                ->update(['is_varified' => $status,'is_accepted'=>1,'updatedby'=>session::get('Uid')]);
                if($result) {
                    $this->_viewContent['requestid']= $requestid;
                    $this->_viewContent['rv']= $rv;
                    $this->_viewContent['type']= 'a';
                    $remarks = Remarks::get();
                  //  dd($remarks);
                    $this->_viewContent['remarks']=  $remarks;
                    $this->_viewContent['page_title'] = "Remarks";
                    return view('request/remarks',$this->_viewContent);
                }else
                {

                    return redirect()->route('editquarter_a', ['r' => $requestid, 'rv' => $rv])->with('success', 'There is some problem in processing request please try again later!');

                }

            }
       }

    /*public function saveFinalAnnexure(request $request)
{

     $status=$request->status;
     $requestid=$request->requestid;
     $dg_allotment=$request->dg_allotment;
     $rv= $request->rv;
     $dg_request_id = TQuarterRequestA::orderBy('requestid', 'DESC')->value('requestid');
     $dg_request_id += 1;
     //get data using request and revision id
    $result=Tquarterrequesta::where('requestid',$requestid)
    ->where('rivision_id',$rv)
    ->first() ;
    //print_r( $result);
    if ($status != 0) {
     try {

         $quarterTypeInstance = new QuarterType();
         $wno = $quarterTypeInstance->getNextWno( $result->quartertype);
       // echo $wno; exit;

         // Retrieve r_wno value
         $rWnoA = TQuarterRequestA::getMaxRwno($result->quartertype);
         $rWnoB = TQuarterRequestB::getMaxRwno($result->quartertype);
         $rWno = max($rWnoA, $rWnoB) + 1;
         // Update the TQuarterRequestA record
         TQuarterRequestA::where('requestid', $requestid)
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

     if ($dg_allotment == 'Y') {
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

                 $quarterTypeInstance = new QuarterType();
                $dg_wno = $quarterTypeInstance->calculateDgWno($dgQuartertype);

             // Create and save a new TQuarterRequestA instance
             $requestModel = TQuarterRequestA::create([
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
                 'request_date' => now(), // Using Laravels helper function to  the current date and time
                 'is_downgrade_request' => 1,
                 'is_priority' => 'N',
                 'reference_id' => $result->requestid,
                 'dg_rivision_id' => $result->rivision_id,
                 'is_varified' => 1,
                 'is_accepted' => 1,
                 'remarks' => '',
                 'updatedBy' => $result->uid,
                 'Wno' => $dg_wno
             ]);

             // Update Dgrid in TQuarterRequestA
             TQuarterRequestA::where('requestid', $requestid)
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


 }
  else
     {
         $result=Tquarterrequesta::where('requestid',$requestid)->where('rivision_id',$rv)
         ->update(['is_varified' => $status,'is_accepted'=>1,'updatedby'=>session::get('Uid')]);
         if($result) {
             $this->_viewContent['requestid']= $requestid;
             $this->_viewContent['rv']= $rv;
             $this->_viewContent['type']= 'a';
             $remarks = Remarks::get();
           //  dd($remarks);
             $this->_viewContent['remarks']=  $remarks;
             $this->_viewContent['page_title'] = "Remarks";
             return view('request/remarks',$this->_viewContent);
         }else
         {

             return redirect()->route('editquarter_a', ['r' => $requestid, 'rv' => $rv])->with('success', 'There is some problem in processing request please try again later!');

         }

     }
}*/
    public function savefinalannexure(request $request)
    {
        $requestid = $request->requestid;
        $downgrade_requestid = $request->dgr;
        $rev = $request->rev;
      //  dd( $rev);
        if ($request->type == 'a') {
            $result = Tquarterrequesta::where('requestid', $requestid)
                ->first();
            if ($downgrade_requestid != "") {
                $downgrade_request = Tquarterrequesta::where('requestid', $requestid)
                    ->first();
                $downgrade_quartertype = $downgrade_request->quartertype;
            }

            $quartertype = $result->quartertype;
            // Count documents where 'performa' contains 'a'
            $doc_tobe_submit = Documenttype::where('performa', 'like', '%a%')->whereNotIn('document_type', [2, 6, 9, 10,3,7])->count();
   
            // Count submitted documents filtered by request ID and 'performa'
            $doc_submitted = Filelist::where('request_id', $requestid)->whereNotIn('document_id', [2, 6, 9, 10,3,7])
                ->where('performa', 'a')
                ->count();
               // dd($doc_tobe_submit,'hii<br>',$doc_submitted);
            if ($doc_tobe_submit != $doc_submitted) { //dd("test");


                return redirect()->action('QuartersController@uploaddocument', [
                    'r' => base64_encode($requestid),
                    'type' => base64_encode($request->type),
                    'rev' => base64_encode($rev)
                ]);
            }
            try {
                $inward_no = '';
                $uid = auth()->id(); // Example: Get user ID, adjust as needed
                $quartertype = $quartertype; // Define quarter type
                $downgrade_requestid = $downgrade_requestid; // Get from request

                while (true) {
                    $inward_no = generateRandomString(5);
                    $inward_no = "$quartertype/" . date('Y') . "/$uid/$inward_no";
                    $co = TQuarterRequestA::where('inward_no', $inward_no)->count();
                    if ($co == 0) break;
                }

                $data = [
                    'inward_no' => $inward_no,
                    'inward_date' => now()->toDateString(),
                    'is_accepted' => 1,
                    'is_priority' => 'N',
                ];

                $resp = TQuarterRequestA::where('requestid', $request->input('requestid'))->update($data);

                // Downgrade Allotment
                if ($downgrade_requestid != "") {
                    $inward_no = '';
                    $downgrade_quartertype =  $downgrade_requestid; // Define downgrade quarter type

                    while (true) {
                        $inward_no = generateRandomString(5);
                        $inward_no = "$downgrade_quartertype/" . date('Y') . "/$uid/$inward_no";
                        $co = TQuarterRequestA::where('inward_no', $inward_no)->count();
                        if ($co == 0) break;
                    }

                    $data = [
                        'inward_no' => $inward_no,
                        'inward_date' => now()->toDateString(),
                        'is_accepted' => 1,
                        'is_priority' => 'N',
                    ];

                    $respdgr = TQuarterRequestA::where('requestid', $downgrade_requestid)->update($data);
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
                dd($pe->getMessage());
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
    public function saveapplication_b(request $request)
    {

        $status = $request->status;
        $requestid = $request->requestid;
        $dg_allotment = $request->dg_allotment;
        $rv = $request->rv;
        $dg_request_id = TQuarterRequestb::orderBy('requestid', 'DESC')->value('requestid');
        $dg_request_id += 1;
        //get data using request and revision id
        $result = Tquarterrequestb::where('requestid', $requestid)
            ->where('rivision_id', $rv)
            ->first();
        //echo "<pre>";  print_r( $result);
        if ($status != 0) {
            try {

                $quarterTypeInstance = new QuarterType();
                $wno = $quarterTypeInstance->getNextWno($result->quartertype);
                // echo $wno; exit;

                // Retrieve r_wno value
                $rWnoA = TQuarterRequestA::getMaxRwno($result->quartertype);
                $rWnoB = TQuarterRequestB::getMaxRwno($result->quartertype);
                $rWno = max($rWnoA, $rWnoB) + 1;
                // Update the TQuarterRequestA record
                TQuarterRequestb::where('requestid', $requestid)
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
            $result = Tquarterrequestb::where('requestid', $requestid)->where('rivision_id', $rv)
                ->update(['is_varified' => $status, 'is_accepted' => 1, 'updatedby' => session::get('Uid')]);
            if ($result) {
                $this->_viewContent['requestid'] = $requestid;
                $this->_viewContent['rv'] = $rv;
                $this->_viewContent['type'] = 'b';
                $remarks = Remarks::get();
                //  dd($remarks);
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
        $result1 = $request->all();
        $type = $result1['type'];
        $requestid = $result1['r'];
        $rv = $result1['rv'];
        $remarks = $result1['remarks'];
        if ($type == 'a') {
            $result = Tquarterrequesta::where('requestid', $requestid)->where('rivision_id', $rv)
                ->update(['remarks' => $remarks, 'remarks_date' => date('Y-m-d')]);
            return redirect('/quarterlistnormal')->with('success', 'Quarter request processed successfully!');
        }
        if ($type == 'b') {
            $result = Tquarterrequestb::where('requestid', $requestid)->where('rivision_id', $rv)
                ->update(['remarks' => $remarks, 'remarks_date' => date('Y-m-d')]);
            return redirect('/quarterlistnormal')->with('success', 'Quarter request processed successfully!');
        }
    }
    public function viewApplication(request $request, $requestid, $rivision_id, $performa)
    {
        if ($performa == 'a') {
            $req_uid = TQuarterRequesta::where('requestid', $requestid)
                ->select('uid')
                ->first();

            $request = TQuarterRequesta::with(['usermaster' => function ($query) {
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
            $req_uid = TQuarterRequestb::where('requestid', $requestid)
                ->select('uid')
                ->first();
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
    
    public function getNormalquarterList(request $request)
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
                'officecode'

            ])
            ->where(function ($query) use ($officecode) {
                $query->where('is_accepted', '=', 1)
                    ->whereNull('remarks')
                    ->where('is_varified', '=', 0)
                    ->where('is_priority', '=', 'N')
                    ->where('is_ddo_varified', '=', 1)
                    ->where('officecode', '=', $officecode)
                    ->orderBy('wno'); // assuming 'wno' is a column in the database
            });

        // Print the SQL query
        //echo $query->toSql();


        return Datatables::of($query)
            ->addColumn('inward_date', function ($date) {
                if ($date->inward_date == '')  return 'N/A';

                return date('d-m-Y', strtotime($date->inward_date));
            })
            ->addColumn('request_date', function ($date) {
                if ($date->request_date == '')  return 'N/A';

                return date('d-m-Y', strtotime($date->request_date));
            })

            ->addColumn('action', function ($row) {
                //  $btn1 =   "edit";
                if ($row->requesttype == 'New') {
                    //  $btn1 = '<a href="'.\route('editquarter', $row->requestid).'" class="btn btn-success "><i class="fas fa-edit"></i></a> ';
                    $btn1 = '<a href="' . \route('editquarter_a', ['r' =>  base64_encode($row->requestid), 'rv' =>  base64_encode($row->rivision_id)]) . '" class="btn btn-success "><i class="fas fa-edit"></i></a>';
                } else {
                    $btn1 = '<a href="' . \route('editquarter_b', ['r' =>  base64_encode($row->requestid), 'rv' =>  base64_encode($row->rivision_id)]) . '" class="btn btn-success "><i class="fas fa-edit"></i></a>';
                }
                return $btn1;
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
    
        // Step 2: Check if the user profile is complete
        if ($basic_pay == null) {
            return redirect('profile')->with('message', "Please complete your profile.");
        }
    
        // Step 3: Get the user data from the User model
        $userdata = User::where('id', $uid)->first();
    
        // Step 4: Check if user exists
        if (!$userdata) {
            return redirect('profile')->with('message', "User not found.");
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
        $wo_unitno=$wo_blockno = $wo_qaid= $cur_qaid = $cur_quartertype = $cur_areacode = $cur_block_no = $cur_unitno = $possesiondate = $wo_areacode = null;
        
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
    
}
