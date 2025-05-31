<?php

namespace App\Http\Controllers;

use App\Tquarterrequestb;
use App\Tquarterrequesta;
use App\Tquarterrequestc;
use App\Documenttype;
use App\QuarterType;
use App\Filelist;
use App\Quarter;
use App\Remarks;
use App\User;
use Carbon\Carbon;
use Session;
use Yajra\Datatables\Datatables;
use DB;
use Mpdf\Mpdf;
use Mpdf\Config\ConfigVariables;
use Mpdf\Config\FontVariables;
use Illuminate\Http\Request;

class DDOUserController extends Controller
{
     // Apply 'auth:ddo_users' middleware to all methods in this controller
     public function __construct()
     {
         $this->middleware('auth:ddo_users');
     }
    public function dashboard()
    {
        $this->_viewContent['page_title'] = "DDO Login";
        return view('ddo.dashboard', $this->_viewContent);
    }
    public function quartersNormal()
    {
        $this->_viewContent['page_title'] = "DDO Login";
        return view('ddo.request.quartersnormal', $this->_viewContent);
    }
    public function quartersRejected()
    {
        $this->_viewContent['page_title'] = "DDO Login";
        return view('ddo.request.quartersrejected', $this->_viewContent);
    }
    
   
    public function geteditquarter_a_old(Request $request, $requestid, $rivision_id)
    {
        $requestid = base64_decode($requestid);
        $rivision_id = base64_decode($rivision_id);

        $requestModel = new TQuarterRequesta();
        $quarterrequest = $requestModel->getFormattedRequestData($requestid, $rivision_id);
        $this->_viewContent['file_uploaded'] = Filelist::select(['document_id', 'rev_id', 'doc_id', 'document_name'])
            ->join('master.m_document_type as d', 'd.document_type', '=', 'file_list.document_id')
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
            'is_varified',
            'uid'
        ])
            ->where('requestid', '=', $requestid)
            ->where('uid', '=', $quarterrequest['uid'])
            ->get();
        $this->_viewContent['requestid'] = $requestid;
        $this->_viewContent['quarterrequest'] = (isset($quarterrequest) && isset($quarterrequest)) ? $quarterrequest : '';
        $this->_viewContent['page_title'] = "Quarter Edit Details";
        return view('ddo.request.updatequarterrequest', $this->_viewContent);
    }
    public function savedocument_a(Request $request)
    {


        $request->validate([
            'getpayslip_certificate' => 'required|not_in:0', // Ensure a valid option is selected
            'image' => 'required|file|mimes:pdf|max:5120', // 5MB max size
        ]);
        try {
            $requestid = base64_decode($request->request_id);
            //19-11-2024
            $rev_id = base64_decode($request->rev_id);
            //dd($requestid);
            $uid = base64_decode($request->uid);
            $doc_type = $request->getpayslip_certificate;
            if ($request->hasFile('image')) {
                //$docId=$request->uid."_".$request->doc_typeid."_paySlip";
                //$docId=$request->uid."_11_paySlip";
                $docId = $uid . "_" . $requestid . "_" . $doc_type . "_a_0";
                // dd($docId);
                uploadDocuments($docId, $request->file('image'), $uid);
                return redirect()->back()->with('success', "Document uploaded successfully");
            }
        } catch (Exception $e) {
            // Return failure response
            return response()->json(['success' => false, 'message' => "ERROR: " . $e->getMessage() . " (" . $e->getCode() . ")"]);
        }
    }
    public function generatecertificate_a(Request $request)
    {

        // Decode the query parameters if necessary
        $requestid = base64_decode($request->request_id);

        $performa = base64_decode($request->performa);

        // $type = base64_decode($performa);
        // $rivision_id = base64_decode($revision_id);
        // $requestModel = new TQuarterRequesta();
        // $data = $requestModel->getFormattedRequestData($requestid, $rivision_id);
        $data = "hello";

        try {
            // Define the path to the font directory
            // $fontDir = __DIR__ . '/vendor/mpdf/mpdf/ttfonts';


            // // Custom font configuration
            // $defaultConfig = (new ConfigVariables())->getDefaults();
            // $fontDirs = $defaultConfig['fontDir'];

            // $defaultFontConfig = (new FontVariables())->getDefaults();
            // $fontData = $defaultFontConfig['fontdata'];

            // // Adding custom font directory and font data
            // $fontDirs = array_merge($fontDirs, [$fontDir]);
            // $fontData = $fontData + [
            //     'ind_gu_1_001' => [
            //         'R' => 'ind_gu_1_001.ttf'
            //     ]
            // ];

            // // Pass the updated font settings to mPDF
            // $mpdf = new Mpdf([
            //     'fontDir' => $fontDirs,
            //     'fontdata' => $fontData,
            //     'default_font' => 'ind_gu_1_001'
            // ]);

            // // Enable auto language and font settings
            // $mpdf->autoScriptToLang = true;
            // $mpdf->autoLangToFont = true;

            // // Load HTML view and render it
            // $html = view('request/applicationview', $data)->render();

            // // Write HTML to PDF
            // $mpdf->WriteHTML($html);
            // dd($mpdf->Output);
            // // Output PDF to browser
            // $mpdf->Output('document.pdf', 'I');

            $mpdf = new Mpdf();

            // Add content to the PDF
            $mpdf->WriteHTML('<h1> Certificate </h1>');
            $mpdf->WriteHTML('<h1>' . $requestid . '</h1>');
            //$mpdf->WriteHTML('<h1>' . $performa . '</h1>');


            // Output the PDF to the browser
            $mpdf->Output('document.pdf', 'I'); // 'I' for inline display in the browser, 'D' for download


        } catch (\Mpdf\MpdfException $e) {
            echo $e->getMessage();
        }
    }
    public function submitdocument_a(Request $request)
    {
        $files= $request->input('files');
     // dd($request->all());
      //  dd($request->submit_issue);
        // dd($request->reqid);
        //Find the record based on the composite primary key
        $requestid = base64_decode($request->reqid);
        $rivision_id = base64_decode($request->rvid);
        $uid = base64_decode($request->uid);
        $qttype = base64_decode($request->qttype);
       // dd($qttype);
        $ddo_remarks = $request->ddo_remarks;
        if (isset($request->submit_issue)) {
            $is_ddo_varified = 2;
        } else {
            $is_ddo_varified = 1;
        }


        // dd($requestid,$rivision_id,$uid,$qttype,$ddo_remarks,$request->submit_issue,$is_ddo_varified);
        if ($is_ddo_varified != 2) {
            $ddo_remarks = null;
        }

        $filetable = Filelist::where('uid', $uid)->get(); // Get all files for the user
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
                  //  dd("on");
                    // Update the file to 'checked'
                 Filelist::where('doc_id', $file->doc_id)
                    ->update(['is_file_ddo_verified' => 1]); // Update      
                } 
            }
            else
            {
                
                Filelist::where('doc_id', $file->doc_id)
                ->update(['is_file_ddo_verified' => 2]); // Update directly
            }

           
        }

     
        try {

            $updated = Tquarterrequesta::where('requestid', $requestid)
                ->where('rivision_id', $rivision_id)
                ->where('uid', $uid)
                ->where('quartertype', $qttype)
                ->update([
                    'is_ddo_varified' => $is_ddo_varified,
                    'ddo_remarks' => $ddo_remarks,  // Assuming $remarks is a variable that contains the remark data
                ]);

            if ($updated) {
                //return response()->json(['message' => 'Documents are submitted successfully!']);
                //return redirect()->back()->with(['message' => 'Review were submitted successfully!']);
                return redirect('/ddo-quarters-normal')->with('success', 'Request Verified Successfully!');
            } else {
                //return response()->json(['message' => 'Record not found or no changes made'], 404);
                return redirect('/ddo-quarters-normal')->back()->with(['message' => 'Something went wrong. Please try again']);
            }
        } catch (\Exception $e) {
            dd($e->getMessage());
            // Log::error('Error updating record: ' . $e->getMessage());
            return response()->json(['message' => 'An error occurred while updating the record'], 500);
        }
    }
   
    public function geteditquarter_a_2212025(Request $request, $requestid, $rivision_id)
    {
        $requestid = base64_decode($requestid);
        $rivision_id = base64_decode($rivision_id);

        $requestModel = new TQuarterRequesta();
        $quarterrequest = $requestModel->getFormattedRequestData($requestid, $rivision_id);
        $this->_viewContent['file_uploaded'] = Filelist::select(['document_id', 'rev_id', 'doc_id', 'document_name', 'is_file_ddo_verified'])
            ->join('master.m_document_type as d', 'd.document_type', '=', 'file_list.document_id')
            ->where('request_id', '=', $requestid)
            ->get(); //12-12-2024


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
            'is_varified',
            'uid'
        ])

            ->where('requestid', '=', $requestid)
            ->where('uid', '=', $quarterrequest['uid'])
            ->get();
        //19-11-2024
        $type = 'a';
        // DB::enableQueryLog();
        $document_list = Documenttype::where('performa', 'LIKE', '%' . $type . '%')
            ->whereIn('document_type', [10])
            ->whereNotIn('document_type',  Filelist::WHERE('uid', $quarterrequest['uid'])
                ->WHERE('request_id', $requestid)->WHERE('performa', $type)
                ->pluck('document_id'))
            ->pluck('document_name', 'document_type');

        // $query = DB::getQueryLog();
        //dd($query);
        // $this->_viewContent['document_list']=$document_list;
        $this->_viewContent['requestid'] = $requestid;
        $this->_viewContent['quarterrequest'] = (isset($quarterrequest) && isset($quarterrequest)) ? $quarterrequest : '';
        $this->_viewContent['page_title'] = "Quarter Edit Details";
        return view('ddo.request.updatequarterrequest', $this->_viewContent);
    }
   
    public function updateFileStatus(Request $request) //13-12-2024
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
        $isVerified = $request->input('is_file_ddo_verified'); // 1 for checked, 2 for unchecked

        // Update the file status
        FileList::where('doc_id', $docId)
            ->update(['is_file_ddo_verified' => $isVerified]);

        // Return a success response
        return response()->json(['success' => true]);
    }
    public function getEmpList()
    {
        $this->_viewContent['page_title'] = "Employees Under DDO Office";
        return view('ddo.emplist', $this->_viewContent);
    }
    public function showEmpList(Request $request)
    {

        $cardexNo = session('cardex_no');
        $ddoCode = session('ddo_code');
        $users = User::select(['name',  'email', 'contact_no','office','designation','appointment_date','date_of_retirement','id'])->where('cardex_no',$cardexNo)->where('ddo_code',$ddoCode)->get();



        return Datatables::of($users)
            ->addIndexColumn()

            ->addColumn('action', function($row){
                return '<a href="'.\route('ddo.viewuserprofile', ['uid' => base64_encode($row->id)]).'" class="btn btn-success "><i class="fas fa-edit"></i></a>';

            })
            ->rawColumns(['action'])
            ->make(true);
    }
    public function geteditquarter_a(Request $request, $requestid, $rivision_id)
    {
        $requestid=base64_decode( $requestid);
        $rivision_id=base64_decode($rivision_id);

        $requestModel = new TQuarterRequesta();
        $quarterrequest = $requestModel->getFormattedRequestData($requestid, $rivision_id);
      
        $this->_viewContent['file_uploaded'] = Filelist::select(['document_id', 'rev_id', 'doc_id', 'document_name','is_file_ddo_verified'])
        ->join('master.m_document_type as d', 'd.document_type', '=', 'file_list.document_id')
        ->where('request_id', '=', $requestid)
        ->where('uid','=',$quarterrequest['uid'])
        ->get(); //12-12-2024


        $this->_viewContent['quarterrequest1'] = Tquarterrequesta::select(['request_date','requestid','quartertype','inward_no','inward_date','rivision_id','remarks',
        'is_accepted','is_allotted','is_varified','uid','ddo_remarks'])

        ->where('requestid','=',$requestid)
        ->where('uid','=',$quarterrequest['uid'])
        ->get();
		//19-11-2024
			$type ='a';
       // DB::enableQueryLog();
        $document_list = Documenttype::where('performa', 'LIKE', '%' . $type . '%')
        ->whereIn('document_type', [10])
        ->whereNotIn('document_type',  Filelist::WHERE('uid', $quarterrequest['uid'])
            ->WHERE('request_id', $requestid)->WHERE('performa', $type)
            ->pluck('document_id'))
        ->pluck('document_name', 'document_type');

       // $query = DB::getQueryLog();
        //dd($query);
           // $this->_viewContent['document_list']=$document_list;
           //23-1-2025
           $officecode = Session::get('officecode');
           $officecode = getOfficeByCode($officecode);
           //dd($officecode);
           $this->_viewContent['officesname'] = isset($officecode[0]->officesnameguj) ? $officecode[0]->officesnameguj : null;

        $this->_viewContent['requestid']=$requestid;
        $this->_viewContent['quarterrequest']=(isset($quarterrequest) && isset($quarterrequest))?$quarterrequest:'';
        $this->_viewContent['page_title'] = "Quarter Edit Details";
        return view('ddo.request.updatequarterrequest',$this->_viewContent);
    }
    public function getNormalquarterList(request $request)
    {
        $cardexNo = session('cardex_no');
        $ddoCode = session('ddo_code');

        \DB::enableQueryLog(); // Enable query log

        $officeCode = session('officecode'); // Get the office code from session
       // dd($cardexNo,$ddoCode,$officeCode);

        $first = DB::table('master.t_quarter_request_a AS a')
        ->select([
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
        'u.ddo_code',
        'u.cardex_no',
        'a.created_at'
       
    ])
    ->join('userschema.users as u', 'u.id', '=', 'a.uid')
    ->join('master.m_ddo as d', 'd.ddo_code', '=', 'a.ddo_code') // Join the ddo table
    ->where('a.ddo_code', $ddoCode) // Filter by ddo_code
    ->where('a.cardex_no',$cardexNo)
    ->where('d.officecode', $officeCode)// Filter by office_code
    ->where('is_accepted', '=', 1)
    ->where('is_ddo_varified',0)
    ->orderBy('a.inward_date', 'asc') ; //12-12-2024   //filter by is_accepted





    $second = DB::table('master.t_quarter_request_c AS c')
    ->select([
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
        'u.ddo_code',
        'u.cardex_no',
        'c.created_at'
        
    ])
    ->join('userschema.users as u', 'u.id', '=', 'c.uid')
    ->join('master.m_ddo as d', 'd.ddo_code', '=', 'c.ddo_code') // Join the ddo table
    ->where('c.ddo_code', $ddoCode) // Filter by ddo_code
    ->where('c.cardex_no',$cardexNo)
    ->where('d.officecode', $officeCode)// Filter by office_code
    ->where('is_accepted', '=', 1)//filter by is_accepted
    ->where('is_ddo_varified',0)
    ->orderBy('c.inward_date', 'asc') ;   //12-12-2024

$union = DB::table('master.t_quarter_request_b AS b')
    ->select([
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
        'u.ddo_code',
        'u.cardex_no',
         'b.created_at'
        

    ])
    ->join('userschema.users as u', 'u.id', '=', 'b.uid')
    ->join('master.m_ddo as d', 'd.ddo_code', '=', 'b.ddo_code') // Join the ddo table
    ->where('b.ddo_code', $ddoCode) // Filter by ddo_code
    ->where('b.cardex_no',$cardexNo)
    ->where('d.officecode', $officeCode) // Filter by office_code
    ->where('is_accepted', '=', 1)  //filter by is_accepted
    ->where('is_ddo_varified',0) //12-12-2024
    ->orderBy('b.inward_date', 'asc') // 
    ->union($first)
    ->union($second);
   
   
    // $queryLog = \DB::getQueryLog();
    // echo $union->toSql();

    // dd($queryLog); // Show results of the log
    
    
        // Print the SQL query
      
// Execute the union query
$results = DB::table(DB::raw("({$union->toSql()}) as combined"))
    ->mergeBindings($union)
    ->orderBy('inward_date', 'asc') // 
    ->get(); // Get the results


    // Display the executed query log
   

    $cnt=0;
    return Datatables::of($results)
    ->addIndexColumn() // Adds an index column named 'DT_RowIndex'
    ->addColumn('inward_date', function ($date) {
        if($date->inward_date=='')  return 'N/A';

        return date('d-m-Y H:i:s',strtotime($date->inward_date));
    })
    ->addColumn('request_date', function ($date) {
        if($date->request_date=='')  return 'N/A';

        return date('d-m-Y',strtotime($date->request_date));
    })
    
    ->addColumn('action', function($row) use (&$cnt) {
        $cnt++; // increment per row processed
        if ($cnt !== 1) return ''; // Only show on the first row

      //  $btn1 =   "edit";
      
    
            if($row->requesttype=='New')
            {
            //  $btn1 = '<a href="'.\route('editquarter', $row->requestid).'" class="btn btn-success "><i class="fas fa-edit"></i></a> ';
            $btn1 = '<a href="'.\route('ddo.editquarter.a.list', ['r' => base64_encode($row->requestid), 'rv' => base64_encode($row->rivision_id)]).'" class="btn btn-success "><i class="fas fa-edit"></i></a>';
            }
            else
            {
            $btn1 = '<a href="'.\route('ddo.editquarter.b.list', ['r' => base64_encode($row->requestid), 'rv' => base64_encode($row->rivision_id)]).'" class="btn btn-success "><i class="fas fa-edit"></i></a>';
            }
           
            return $btn1;
       
         
       
     })
    /* ->addColumn('delete', function($row){
         $btn1 ='<a href="' . \URL::action('QuartersController@uploaddocument'). "?r=" . base64_encode($row->requestid)."&type=". base64_encode($row->type)."&rev=". base64_encode($row->rivision_id).'" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>';
         return $btn1;
     })*/
     ->rawColumns(['delete','action'])
    ->make(true);
    }
    public function getuserprofile($uid)
    {

        
        $uid=\base64_decode($uid);
       // dd($uid);
        $officecode = Session::get('officecode');
        $officecode = getOfficeByCode($officecode);
        $data['officesname'] = isset($officecode[0]->officesnameguj) ? $officecode[0]->officesnameguj : null;
        //dd($data);

           //23-1-2025
           $officecode = Session::get('officecode');
           $officecode = getOfficeByCode($officecode);
           //dd($officecode);
           $this->_viewContent['officesname'] = isset($officecode[0]->officesnameguj) ? $officecode[0]->officesnameguj : null;

           $usermaster = User::find($uid);
           //$newquarterrequest=Tquarterrequesta::find($uid);
           $newquarterrequest=Tquarterrequesta::select('*')->where('uid',$uid)->get();
           //$newhigherquarterrequest=Tquarterrequestb::find($uid);
      //  dd($newquarterrequest);
          // dd($usermaster);
           $this->_viewContent['userDetail']=$usermaster;
           $this->_viewContent['imageData'] = generateImage($uid);
        //dd($this->_viewContent['imageData'] );
        $this->_viewContent['page_title'] = "Employee Details";
        return view('ddo.emp.viewuserprofile',$this->_viewContent);
    }

    public function getUserQuarterApplication(Request $request)
    {
        $cardexNo = session('cardex_no');
        $ddoCode = session('ddo_code');
        $uid=\base64_decode($request->uid);
     //   \DB::enableQueryLog(); // Enable query log

        $officeCode = session('officecode'); // Get the office code from session
       // dd($cardexNo,$ddoCode,$officeCode);

        $first = DB::table('master.t_quarter_request_a AS a')
        ->select([
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
        'u.ddo_code',
        'u.cardex_no'
    ])
    ->join('userschema.users as u', 'u.id', '=', $uid)
    ->join('master.m_ddo as d', 'd.ddo_code', '=', 'a.ddo_code') // Join the ddo table
    ->where('a.ddo_code', $ddoCode) // Filter by ddo_code
    ->where('a.cardex_no',$cardexNo)
    ->where('d.officecode', $officeCode)// Filter by office_code
    ->where('is_accepted', '=', 1)
    ->whereIn('is_ddo_varified',[0,2]) //12-12-2024   //filter by is_accepted
    ->where('u.id', '=', $uid);  // Filter by uid (user ID)





    $second = DB::table('master.t_quarter_request_c AS c')
    ->select([
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
        'u.ddo_code',
        'u.cardex_no'
    ])
    ->join('userschema.users as u', 'u.id', '=', $uid)
    ->join('master.m_ddo as d', 'd.ddo_code', '=', 'c.ddo_code') // Join the ddo table
    ->where('c.ddo_code', $ddoCode) // Filter by ddo_code
    ->where('c.cardex_no',$cardexNo)
    ->where('d.officecode', $officeCode)// Filter by office_code
    ->where('is_accepted', '=', 1)//filter by is_accepted
    ->whereIn('is_ddo_varified',[0,2])   //12-12-2024
    ->where('u.id', '=', $uid); 

$union = DB::table('master.t_quarter_request_b AS b')
    ->select([
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
        'u.ddo_code',
        'u.cardex_no'
    ])
    ->join('userschema.users as u', 'u.id', '=', 'b.uid')
    ->join('master.m_ddo as d', 'd.ddo_code', '=', 'b.ddo_code') // Join the ddo table
    ->where('b.ddo_code', $ddoCode) // Filter by ddo_code
    ->where('b.cardex_no',$cardexNo)
    ->where('d.officecode', $officeCode) // Filter by office_code
    ->where('is_accepted', '=', 1)  //filter by is_accepted
    ->whereIn('is_ddo_varified',[0,2]) //12-12-2024
    ->union($first)
    ->union($second);

// Execute the union query
$results = DB::table(DB::raw("({$union->toSql()}) as combined"))
    ->mergeBindings($union)
    ->get(); // Get the results

// Display the executed query log
//$queryLog = \DB::getQueryLog();
//dd($queryLog); // Show results of the log


    // Print the SQL query
  //  echo $query->toSql();


    return Datatables::of($results)
    ->addColumn('inward_date', function ($date) {
        if($date->inward_date=='')  return 'N/A';

        return date('d-m-Y',strtotime($date->inward_date));
    })
    ->addColumn('request_date', function ($date) {
        if($date->request_date=='')  return 'N/A';

        return date('d-m-Y',strtotime($date->request_date));
    })

    ->addColumn('action', function($row){
      //  $btn1 =   "edit";
        if($row->requesttype=='New')
        {
        //  $btn1 = '<a href="'.\route('editquarter', $row->requestid).'" class="btn btn-success "><i class="fas fa-edit"></i></a> ';
        $btn1 = '<a href="'.\route('ddo.editquarter.a.list', ['r' => base64_encode($row->requestid), 'rv' => base64_encode($row->rivision_id)]).'" class="btn btn-success "><i class="fas fa-edit"></i></a>';
        }
        else
        {
        $btn1 = '<a href="'.\route('ddo.editquarter.b.list', ['r' => base64_encode($row->requestid), 'rv' => base64_encode($row->rivision_id)]).'" class="btn btn-success "><i class="fas fa-edit"></i></a>';
        }
        return $btn1;
     })
    /* ->addColumn('delete', function($row){
         $btn1 ='<a href="' . \URL::action('QuartersController@uploaddocument'). "?r=" . base64_encode($row->requestid)."&type=". base64_encode($row->type)."&rev=". base64_encode($row->rivision_id).'" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>';
         return $btn1;
     })*/
     ->rawColumns(['delete','action'])
    ->make(true);
    }
    public function geteditquarter_b(Request $request, $requestid, $rivision_id)
    {
       
        $requestid=base64_decode( $requestid);
        $rivision_id=base64_decode($rivision_id);
        //dd($requestid,$rivision_id); 
        $requestModel = new Tquarterrequestb();
        $quarterrequest = $requestModel->getFormattedRequestData($requestid, $rivision_id);
        //dd($quarterrequest);
        $this->_viewContent['file_uploaded'] = Filelist::select(['document_id', 'rev_id', 'doc_id', 'document_name','is_file_ddo_verified'])
        ->join('master.m_document_type as d', 'd.document_type', '=', 'file_list.document_id')
        ->where('request_id', '=', $requestid)
        ->where('uid','=',$quarterrequest['uid'])
        ->get(); //12-12-2024

       // dd($this->_viewContent['file_uploaded']);

        $this->_viewContent['quarterrequest1'] = Tquarterrequestb::select(['request_date','requestid','quartertype','inward_no','inward_date','rivision_id','remarks',
        'is_accepted','is_allotted','is_varified','uid','ddo_remarks'])
        ->where('requestid','=',$requestid)
        ->where('uid','=',$quarterrequest['uid'])
        ->get();
       // dd($this->_viewContent['quarterrequest1']);
        $type ='b';
       //  DB::enableQueryLog();
            $document_list = Documenttype::where('performa', 'LIKE', '%' . $type . '%')
            ->whereIn('document_type', [10])
            ->whereNotIn('document_type', Filelist::WHERE('uid', $quarterrequest['uid'])
            ->WHERE('request_id', $requestid)->WHERE('performa', $type)
            ->pluck('document_id'))
            ->pluck('document_name', 'document_type');
            
       // dd($document_list);
         $query = DB::getQueryLog();
       // dd($query);
        // $this->_viewContent['document_list']=$document_list;
        //23-1-2025
        $officecode = Session::get('officecode');
        $officecode = getOfficeByCode($officecode);
        //dd($officecode);
        $this->_viewContent['officesname'] = isset($officecode[0]->officesnameguj) ? $officecode[0]->officesnameguj : null;

        $this->_viewContent['requestid']=$requestid;
        $this->_viewContent['quarterrequest']=(isset($quarterrequest) && isset($quarterrequest))?$quarterrequest:'';
        $this->_viewContent['page_title'] = "Quarter Edit Details";
        return view('ddo.request.updatequarterrequestb',$this->_viewContent);


    }

    public function getRejectedQuarterList()
    {
        $cardexNo = session('cardex_no');
        $ddoCode = session('ddo_code');

        \DB::enableQueryLog(); // Enable query log

        $officeCode = session('officecode'); // Get the office code from session
       // dd($cardexNo,$ddoCode,$officeCode);

        $first = DB::table('master.t_quarter_request_a AS a')
        ->select([
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
        'a.ddo_remarks',
        'contact_no',
        'address',
        'gpfnumber',
        'is_accepted',
        'is_allotted',
        'is_varified',
        'email',
        'is_priority',
        'u.ddo_code',
        'u.cardex_no',
        'u.id',
        'a.created_at'
       
    ])
    ->join('userschema.users as u', 'u.id', '=', 'a.uid')
    ->join('master.m_ddo as d', 'd.ddo_code', '=', 'a.ddo_code') // Join the ddo table
    ->where('a.ddo_code', $ddoCode) // Filter by ddo_code
    ->where('a.cardex_no',$cardexNo)
    ->where('d.officecode', $officeCode)// Filter by office_code
    ->where('is_accepted', '=', 1)
    ->where('is_ddo_varified',2)
    ->orderBy('a.inward_date', 'asc') ; //12-12-2024   //filter by is_accepted





    $second = DB::table('master.t_quarter_request_c AS c')
    ->select([
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
        'c.ddo_remarks',
        'contact_no',
        'address',
        'gpfnumber',
        'is_accepted',
        'is_allotted',
        'is_varified',
        'email',
        'is_priority',
        'u.ddo_code',
        'u.cardex_no',
        'u.id',
        'c.created_at'
        
    ])
    ->join('userschema.users as u', 'u.id', '=', 'c.uid')
    ->join('master.m_ddo as d', 'd.ddo_code', '=', 'c.ddo_code') // Join the ddo table
    ->where('c.ddo_code', $ddoCode) // Filter by ddo_code
    ->where('c.cardex_no',$cardexNo)
    ->where('d.officecode', $officeCode)// Filter by office_code
    ->where('is_accepted', '=', 1)//filter by is_accepted
    ->where('is_ddo_varified',2)
    ->orderBy('c.inward_date', 'asc') ;   //12-12-2024

$union = DB::table('master.t_quarter_request_b AS b')
    ->select([
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
        'b.ddo_remarks',
        'contact_no',
        'address',
        'gpfnumber',
        'is_accepted',
        'is_allotted',
        'is_varified',
        'email',
        'is_priority',
        'u.ddo_code',
        'u.cardex_no',
        'u.id',
         'b.created_at'
        

    ])
    ->join('userschema.users as u', 'u.id', '=', 'b.uid')
    ->join('master.m_ddo as d', 'd.ddo_code', '=', 'b.ddo_code') // Join the ddo table
    ->where('b.ddo_code', $ddoCode) // Filter by ddo_code
    ->where('b.cardex_no',$cardexNo)
    ->where('d.officecode', $officeCode) // Filter by office_code
    ->where('is_accepted', '=', 1)  //filter by is_accepted
    ->where('is_ddo_varified',2) //12-12-2024
    ->orderBy('b.inward_date', 'asc') // 
    ->union($first)
    ->union($second);
   
   
    // $queryLog = \DB::getQueryLog();
    // echo $union->toSql();

    // dd($queryLog); // Show results of the log
    
    
        // Print the SQL query
      
// Execute the union query
$results = DB::table(DB::raw("({$union->toSql()}) as combined"))
    ->mergeBindings($union)
    ->orderBy('inward_date', 'asc') // 
    ->get(); // Get the results


    // Display the executed query log
   

   
    return Datatables::of($results)
    ->addIndexColumn() // Adds an index column named 'DT_RowIndex'
    ->addColumn('inward_date', function ($date) {
        if($date->inward_date=='')  return 'N/A';

        return date('d-m-Y',strtotime($date->inward_date));
    })
    ->addColumn('request_date', function ($date) {
        if($date->request_date=='')  return 'N/A';

        return date('d-m-Y',strtotime($date->request_date));
    })
    
    ->addColumn('action', function($row) use (&$cnt) {
       
    
            // if($row->requesttype=='New')
            // {

            // //  $btn1 = '<a href="'.\route('editquarter', $row->requestid).'" class="btn btn-success "><i class="fas fa-edit"></i></a> ';
            // $btn1 = '<a href="'.\route('ddo.editquarter.a.list', ['r' => base64_encode($row->requestid), 'rv' => base64_encode($row->rivision_id)]).'" class="btn btn-success "><i class="fas fa-edit"></i> View Remarks</a>';
            // }
            // else
            // {
            // $btn1 = '<a href="'.\route('ddo.editquarter.b.list', ['r' => base64_encode($row->requestid), 'rv' => base64_encode($row->rivision_id)]).'" class="btn btn-success "><i class="fas fa-edit"></i> View Remarks</a>';
            // }
           
            // return $btn1;
            $btn2 = '<button type="button" data-uid="'.base64_encode($row->id).'" data-rivision_id="'.base64_encode($row->rivision_id).'"data-type="'.base64_encode($row->type).'"  data-requestid="'.base64_encode($row->requestid).'"  data-remarks="'.base64_encode($row->ddo_remarks).'" data-toggle="modal"  class=" btn-view-custom getdocument" > View Remarks</button>';

            return $btn2;
       
         
       
     })
    /* ->addColumn('delete', function($row){
         $btn1 ='<a href="' . \URL::action('QuartersController@uploaddocument'). "?r=" . base64_encode($row->requestid)."&type=". base64_encode($row->type)."&rev=". base64_encode($row->rivision_id).'" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>';
         return $btn1;
     })*/
     ->rawColumns(['delete','action'])
    ->make(true);
    }
    public function submitdocument_b(Request $request)
    {
        $files= $request->input('files');
      //dd($request->all());
      //  dd($request->submit_issue);
        // dd($request->reqid);
        //Find the record based on the composite primary key
        $requestid = base64_decode($request->reqid);
        $rivision_id = base64_decode($request->rvid);
        $uid = base64_decode($request->uid);
        $qttype = base64_decode($request->qttype);
        //dd($qttype);
        $ddo_remarks = $request->ddo_remarks;
        if (isset($request->submit_issue)) {
            $is_ddo_varified = 2;
        } else {
            $is_ddo_varified = 1;
        }


        // dd($requestid,$rivision_id,$uid,$qttype,$ddo_remarks,$request->submit_issue,$is_ddo_varified);
        if ($is_ddo_varified != 2) {
            $ddo_remarks = null;
        }

        $filetable = Filelist::where('uid', $uid)->get(); // Get all files for the user
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
                  //  dd("on");
                    // Update the file to 'checked'
                 Filelist::where('doc_id', $file->doc_id)
                    ->update(['is_file_ddo_verified' => 1]); // Update      
                } 
            }
            else
            {
                
                Filelist::where('doc_id', $file->doc_id)
                ->update(['is_file_ddo_verified' => 2]); // Update directly
            }

           
        }

       
        try {

            $updated = Tquarterrequestb::where('requestid', $requestid)
                ->where('rivision_id', $rivision_id)
                ->where('uid', $uid)
                ->where('quartertype', $qttype)
                ->update([
                    'is_ddo_varified' => $is_ddo_varified,
                    'ddo_remarks' => $ddo_remarks,  // Assuming $remarks is a variable that contains the remark data
                ]);

            if ($updated) {
                //return response()->json(['message' => 'Documents are submitted successfully!']);
                //return redirect()->back()->with(['message' => 'Review were submitted successfully!']);
                return redirect('/ddo-quarters-normal')->with('success', 'Request Verified Successfully!');
            } else {
                //return response()->json(['message' => 'Record not found or no changes made'], 404);
                return redirect('/ddo-quarters-normal')->back()->with(['message' => 'Something went wrong. Please try again']);
            }
        } catch (\Exception $e) {
            dd($e->getMessage());
            // Log::error('Error updating record: ' . $e->getMessage());
            return response()->json(['message' => 'An error occurred while updating the record'], 500);
        }
    }

    public function getDDOremarks(Request $request)
    {
        // dd($request->all());
        $uid=base64_decode($request->uid);
        $type=base64_decode($request->type);
        $rivision_id=base64_decode($request->rivision_id);
        $requestid=base64_decode($request->requestid);
        $remarks=base64_decode($request->remarks);
      
      
       
      //  return response()->json($remarksdata);
      
       if ($remarks=='') {
        return response()->json([
            'success' => false,
            'data' => [],
            'message' => 'No Data Found'
        ]);
    } else {
        $remarksArray = explode(',', $remarks);
        $remarksdata=Remarks::select('description')->whereIn('remark_id',$remarksArray)->get();
        return response()->json([
            'success' => true,
            'data' => $remarksdata
        ]);
    }
    }
}
