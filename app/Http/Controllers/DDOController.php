<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DDOCode;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DDOController extends Controller
{
    var $_viewContent = [];

    public function __construct()
    {
        $this->middleware('auth');
    }

    // Show list page
    public function index()
    {
        $this->_viewContent['page_title'] = "DDO List";
        return view('ddo.index', $this->_viewContent);
    }

    // Datatable JSON for DDO list
    public function show_ddolist(Request $request)
    {
        $officecode = session('officecode');
        try {
            $query = DDOCode::where('officecode', $officecode);

            return Datatables::of($query)
                ->addColumn('action', function ($row) {
                    $editUrl = route('ddo.edit', $row->id);
                    $btn = "<a href='{$editUrl}' class='btn btn-success'><i class='fas fa-edit'></i></a>";
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => "ERROR: " . $e->getMessage()]);
        }
    }

    // Show Add New DDO form
   public function addNewDDO($id = null)
{
    $this->_viewContent['page_title'] = $id ? "Edit DDO" : "Add New DDO";
    $this->_viewContent['district']=getDistrictsByOfficeCode(Session::get('officecode'));
    //dd($this->_viewContent['district']);
    if ($id) {
        $ddo = DDOCode::findOrFail($id);
        $this->_viewContent['ddo'] = $ddo;
    } else {
        // Generate random code only for new DDOs
        // $random_number = rand(100000, 999999);
        // $random_alpha = chr(rand(65, 90));
        // $this->_viewContent['ddo_code'] = 'OTH' . $random_number . $random_alpha;

        do {
            $random_number = rand(100000, 999999);
            $random_alpha = chr(rand(65, 90));
            $ddo_code = 'OTH' . $random_number . $random_alpha;
        } while (DDOCode::where('ddo_reg_no', $ddo_code)->exists());
       
       $this->_viewContent['district']=getDistrictsByOfficeCode(Session::get('officecode'));
       // dd($this->_viewContent['district']);
        $this->_viewContent['ddo_code'] = $ddo_code;

    }

    return view('ddo.addNewDDO', $this->_viewContent);
}

    // Store or update DDO data
public function addNewDDOStore(Request $request)
{
    try {

        $id = $request->input('id');

        // =====================================
        // UNIQUE EMAIL RULE (OLD WORKING LOGIC)
        // =====================================

        $uniqueEmailRule = 'unique:App\DDOCode,ddo_office_email_id';

        if ($id) {

            $uniqueEmailRule .= ',' . $id . ',id';
        }

        // =====================================
        // VALIDATION RULES
        // =====================================

        $rules = [

            'ddocode' => 'required|digits_between:1,4',

            'ddoofficename' => [
                'required',
                'regex:/^[\p{L}\s]+$/u'
            ],

            'district' => 'required',

            'cardex_no' => 'required|digits_between:1,50',

            'ddo_registration_no' => [
                'required',
                'regex:/^(SGV|OTH)\d{6}[A-Z]$/'
            ],

            'ddo_office_email_id' => [

                'required',

                'email',

                function ($attribute, $value, $fail) {

                    $allowedDomains = [

                        'gujarat.gov.in',
                        'gujgov.edu.in',
                        'gsbstb.org',
                        'gsrtc.org',
                        'gipc.co.in'

                    ];

                    $domain = strtolower(
                        substr(strrchr($value, "@"), 1)
                    );

                    if (!in_array($domain, $allowedDomains)) {

                        $fail(
                            'Invalid email. Allowed domains: ' .
                            implode(', ', $allowedDomains)
                        );
                    }
                },

                $uniqueEmailRule,

            ],

        ];

        // =====================================
        // VALIDATION MESSAGES
        // =====================================

        $messages = [

            'ddocode.required' =>
                'DDO Code is required',

            'ddocode.digits_between' =>
                'DDO Code must be digits and not more than 4 digits long',

            'ddoofficename.required' =>
                'DDO Office name is required',

            'ddoofficename.regex' =>
                'DDO Office name must contain only letters and spaces',

            'district.required' =>
                'District is required',

            'cardex_no.required' =>
                'Cardex No is required',

            'cardex_no.digits_between' =>
                'Cardex No must contain only digits',

            'ddo_registration_no.required' =>
                'DDO Registration No is required',

            'ddo_registration_no.regex' =>
                'DDO Registration No must start with SGV or OTH, followed by 6 digits and end with an uppercase letter.',

            'ddo_office_email_id.required' =>
                'Email is required',

            'ddo_office_email_id.email' =>
                'Please enter a valid email address',

            'ddo_office_email_id.unique' =>
                'This email has already been taken',

        ];

        // =====================================
        // VALIDATE REQUEST
        // =====================================

        $validator = Validator::make(
            $request->all(),
            $rules,
            $messages
        );

        if ($validator->fails()) {

            return response()->json([

                'success' => false,

                'errors' => $validator->errors()

            ], 422);
        }

        // =====================================
        // GET DISTRICT NAME
        // =====================================

        $districtName = DB::table('master.districts')
        ->where('dcode', $request->district)
        ->value('name_e');

        // =====================================
        // SESSION DATA
        // =====================================

        $officecode = Session::get('officecode');

        // =====================================
        // UPDATE
        // =====================================

        if ($id) {

            DDOCode::where('id', $id)->update([

                'dcode' => $request->district,

                'district' => $districtName,

                'ddo_code' => $request->ddocode,

                'cardex_no' => $request->cardex_no,

                'ddo_reg_no' => $request->ddo_registration_no,

                'ddo_office' => $request->ddoofficename,

                'ddo_office_email_id' =>
                    $request->ddo_office_email_id,

                'officecode' => $officecode,

            ]);

            $message = 'DDO updated successfully';

        } else {

            // =====================================
            // CREATE
            // =====================================

            DDOCode::create([

                'dcode' => $request->district,

                'district' => $districtName,

                'ddo_code' => $request->ddocode,

                'cardex_no' => $request->cardex_no,

                'ddo_reg_no' => $request->ddo_registration_no,

                'ddo_office' => $request->ddoofficename,

                'ddo_office_email_id' =>
                    $request->ddo_office_email_id,

                'password' =>
                    Hash::make('Admin@1357'),

                'officecode' => $officecode,

            ]);

            $message = 'DDO added successfully';
        }

        // =====================================
        // SUCCESS RESPONSE
        // =====================================

        return response()->json([

            'success' => true,

            'message' => $message

        ], 200); 

    } catch (\Exception $e) {

        return response()->json([

            'success' => false,

            'message' => $e->getMessage()

        ], 500);
    }
}
    public function ddoResetPwd(Request $request)
    {
        try{
                $id = $request->input('id');
                if ($id) {
                    DDOCode::where('id', $id)->update([
                        'password' => Hash::make('Admin@1357'),]);
        //     return response()->json([
        //     'success' => true,
        //     'message' => 'Password has been reset successfully',
        // ]);
        
        // ✅ Redirect to EDIT page (GET route)
        return redirect()
            ->route('ddo.edit', $id)
            ->with('success', 'Password has been reset successfully');

                    }
    }
catch (\Exception $e) { //dd($e->getMessage());
             return redirect()
                ->back()
                ->withInput() // keep previous input
                ->with('error', 'ERROR: ' . $e->getMessage());
        }
    }
}