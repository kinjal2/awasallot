<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DdoList;
use App\DDOCode;
use DB;
use Yajra\Datatables\Datatables;


class DDOController extends Controller
{
    var $viewContent = [];
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $this->_viewContent['page_title'] = "DDO List";
        return view('ddo.index',$this->_viewContent);
    }
    public function show_ddolist(Request $request)
    {
        try{
           // $query = DdoList::all();
				$query = DDOCode::all();				   
            return Datatables::of($query)
            ->addColumn('action', function($row){
                $btn1 = "<a href='#' class='btn btn-success'><i class='fas fa-edit'></i></a>";
                return $btn1;
                })
            ->rawColumns(['action'])
                ->make(true);
         }
        catch(Exception $e)
        {
            // Return failure response
            return response()->json(['success' => false, 'message' => "ERROR: " . $e->getMessage() . " (" . $e->getCode() . ")"]);
        }
    }
    public function addNewDDOStore(Request $request)
    {

        try{
            // Validate the request with rules and custom messages
             $request->validate([
				'ddocode' => 'required|digits_between:1,4',										   
                'ddoofficename' => 'required|regex:/^[\p{L}\s]+$/u', // Letters and spaces
                'districtname' => 'required|regex:/^[\p{L}\s]+$/u', // Letters and spaces
                'cardex_no' => 'required|digits_between:1,50', // Digits only
                'ddo_registration_no' => 'required|alpha_num|size:10', // Letters and digits of length 10
               // 'dto_registration_no' => 'required|digits:7', // Not more than 7 digits
                'ddo_office_email_id' => 'required|email',
                //'mobile' => 'required|digits:10', // Exactly 10 digits
        ], [
			'ddocode.required' => 'DDO Code is required',
            'ddocode.digits_between' => 'DDO Code must be digitsand not more than 4 digits long',																					 
            'ddoofficename.required' => 'DDO Office name is required',
            'ddoofficename.regex' => 'DDO Office name must contain only letters and spaces',
            'districtname.required' => 'District name is required',
            'districtname.regex' => 'District name must contain only letters and spaces',
            'cardex_no.required' => 'Cardex No is required',
            'cardex_no.digits_between' => 'Cardex No must contain only digits',
            'ddo_registration_no.required' => 'DDO Registration No is required',
            'ddo_registration_no.alpha_num' => 'DDO Registration No must contain only letters and numbers',
            'ddo_registration_no.size' => 'DDO Registration No must be exactly 10 characters long',
           // 'dto_registration_no.required' => 'DTO Registration No is required',
           // 'dto_registration_no.digits' => 'DTO Registration must be exactly 7 digits',
            'ddo_office_email_id.required' => 'Email is required',
            'ddo_office_email_id.email' => 'Please enter a valid email address',
            //'mobile.required' => 'Mobile No is required',
            //'mobile.digits' => 'Mobile No must be exactly 10 digits long',
        ]);

        // Store the data in your database
       // DdoList::Create(['ddo_office_name' => $request->ddoofficename, 'district_name' => $request->districtname, 'cardex_no' => $request->cardex_no,'ddo_registration_no' => $request->ddo_registration_no,'dto_registration_no'=>$request->dto_registration_no,'email' => $request->email,'mobile_no' => $request->mobile]);
	   
	   DDOCode::Create(['district' => $request->districtname,'ddo_code' => $request->ddocode,'cardex_no' => $request->cardex_no, 'ddo_reg_no' => $request->ddo_registration_no,'ddo_office' => $request->ddoofficename,'ddo_office_email_id' => $request->ddo_office_email_id]);


            return response()->json(['success'=>'DDO saved successfully.']);
        // Flash a success message to the session
           // return redirect(route('ddo.list'))->with('success', 'DDO saved successfully.');
        }
        catch(Exception $e)
        {
            // Return failure response
            return response()->json(['success' => false, 'message' => "ERROR: " . $e->getMessage() . " (" . $e->getCode() . ")"]);
        }
    }
    public function addNewDDO()
    {
        $this->_viewContent['page_title'] = "Add New DDO";
        return view('ddo.addNewDDO',$this->_viewContent);
    }

    /*public function getDDOCode(Request $request)
    {
        // Validate the input
        $request->validate([
            'cardex_no' => 'required|string',
        ]);

        $cardexNo = $request->input('cardex_no');

        // Fetch data from your database based on cardex_no
        $data = DDOCode::where('cardex_no', '=', $cardexNo)->get(['ddo_code', 'ddo_office']); // Adjust fields as necessary

        return response()->json($data);
    }   */
}
