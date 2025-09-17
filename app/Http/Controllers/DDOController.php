<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DDOCode;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

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
        $this->_viewContent['ddo_code'] = $ddo_code;

    }

    return view('ddo.addNewDDO', $this->_viewContent);
}

    // Store or update DDO data
    public function addNewDDOStore(Request $request)
    {
        //dd($request->all());
        $id = $request->input('id');
        try {
            // Prepare the unique rule for email
                $uniqueEmailRule = 'unique:App\DDOCode,ddo_office_email_id';
                if ($id) {
                    $uniqueEmailRule .= ',' . $id . ',id';
                }

                // Validation rules
                $rules = [
                    'ddocode' => 'required|digits_between:1,4',
                    'ddoofficename' => ['required', 'regex:/^[\p{L}\s]+$/u'],
                    'districtname' => ['required', 'regex:/^[\p{L}\s]+$/u'],
                    'cardex_no' => 'required|digits_between:1,50',
                    'ddo_registration_no' => ['required', 'regex:/^(SGV|OTH)\d{6}[A-Z]$/'],
                    'ddo_office_email_id' => [
                        'required',
                        'email',
                        'regex:/^[a-zA-Z0-9._%+-]+@gujarat\.gov\.in$/',
                        $uniqueEmailRule, // ✅ Final working string-based unique rule
                    ],
                ];

                // Validation messages
                $messages = [
                    'ddocode.required' => 'DDO Code is required',
                    'ddocode.digits_between' => 'DDO Code must be digits and not more than 4 digits long',
                    'ddoofficename.required' => 'DDO Office name is required',
                    'ddoofficename.regex' => 'DDO Office name must contain only letters and spaces',
                    'districtname.required' => 'District name is required',
                    'districtname.regex' => 'District name must contain only letters and spaces',
                    'cardex_no.required' => 'Cardex No is required',
                    'cardex_no.digits_between' => 'Cardex No must contain only digits',
                    'ddo_registration_no.required' => 'DDO Registration No is required',
                    'ddo_registration_no.regex' => 'DDO Registration No must start with SGV or OTH, followed by 6 digits and end with an uppercase letter.',
                    'ddo_office_email_id.required' => 'Email is required',
                    'ddo_office_email_id.email' => 'Please enter a valid email address',
                    'ddo_office_email_id.regex' => 'Invalid email. Email must end with @gujarat.gov.in.',
                    'ddo_office_email_id.unique' => 'This email has already been taken',
                ];

                // Apply validation
                $request->validate($rules, $messages);


            $officecode = Session::get('officecode');

            if ($id) {
                // Update
              // Update
           

            DDOCode::where('id', $id)->update([
                'dcode' => $request->district,
                'district' => $request->districtname,
                'ddo_code' => $request->ddocode,
                'cardex_no' => $request->cardex_no,
                'ddo_reg_no' => $request->ddo_registration_no,
                'ddo_office' => $request->ddoofficename,
                'ddo_office_email_id' => $request->ddo_office_email_id,
                'officecode' => $officecode,
            ]);

            
            

            
            } else {
                // Create new
                DDOCode::create([
                    'dcode' => $request->district,
                    'district' => $request->districtname,
                    'ddo_code' => $request->ddocode,
                    'cardex_no' => $request->cardex_no,
                    'ddo_reg_no' => $request->ddo_registration_no,
                    'ddo_office' => $request->ddoofficename,
                    'ddo_office_email_id' => $request->ddo_office_email_id,
                    'password' => Hash::make('Admin@1357'), // Default password
                    'officecode' => $officecode,
                ]);
            }
              //  dd('Reached redirect'); 
        return response()->json([
    'success' => true,
    'message' => $id ? 'DDO updated successfully' : 'DDO added successfully',
]);


        } catch (\Exception $e) { dd("fdgfd".$e->getMessage());
             return redirect()
                ->back()
                ->withInput() // keep previous input
                ->with('error', 'ERROR: ' . $e->getMessage());
        }
    }
}
