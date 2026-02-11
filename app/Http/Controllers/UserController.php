<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Yajra\DataTables\DataTables;
use DB;
use App\DataTables\UsersDataTable;
use App\DataTables\UsersDataTablesEditor;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
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
        $this->_viewContent['page_title'] = "User";
        return view('admin/user', $this->_viewContent);
    }
    public function getList(Request $request)
    {

        $search = $request->input('search');
        $officecode = Session::get('officecode');

        /* $columnFilters = [
        'id' => $request->input('id'),
        'name' => $request->input('name'),
        'designation' => $request->input('designation'),
        'date_of_birth' => $request->input('date_of_birth'),
        'office' => $request->input('office'),
        'email' => $request->input('email'),
      
    ];*/
        $users = User::select(['name', 'date_of_birth', 'designation', 'office', 'email', 'id', 'dcode', 'tcode', 'ddo_code', 'cardex_no']);

        // Apply global search
        /*if ($request->has('search') && $request->input('search')) {
            $search = $request->input('search');
            $search= $search['value'];
            $users->where(function ($query) use ($search) {
                $query->where('name', 'like', "%$search%")
                      ->orWhere('designation', 'like', "%$search%")
                      ->orWhere('date_of_birth', 'like', "%$search%")
                      ->orWhere('office', 'like', "%$search%")
                      ->orWhere('email', 'like', "%$search%")
                      ->orWhere('id', 'like', "%$search%");
            });
        } */

        $columns = $request->input('columns');

        if (!empty($columns)) {
            foreach ($columns as $column) {
                if (!empty($column['search']['value'])) {
                    $searchValue = $column['search']['value'];
                    $columnName  = $column['name'];

                    // Exact match for ID
                    if ($columnName === 'id') {
                        $users->where('id', $searchValue);
                    } else if ($columnName === 'ddocardex') {
                        // Split by "/"
                        $parts = array_map('trim', explode('/', $searchValue));

                        $cardex = $parts[0] ?? null;
                        $ddo    = $parts[1] ?? null;

                        // Apply conditions safely
                        $users->where(function ($q) use ($cardex, $ddo) {

                            if ($cardex !== null && $cardex !== '') {
                                $q->where('cardex_no', $cardex);
                            }

                            if ($ddo !== null && $ddo !== '') {
                                $q->where('ddo_code', $ddo);
                            }
                        });
                    } else {
                        $users->where($columnName, 'like', "%{$searchValue}%");
                    }
                }
            }
        }

        // Apply column filters
        /* foreach ($columnFilters as $column => $filter) {
        if ($filter) {
            $users->where($column, 'like', '%' . $filter . '%');
        }
    }*/

        return Datatables::of($users)
            ->addIndexColumn()
            ->addColumn('id', function ($row) {
                return $row->id;
            })
            ->addColumn('name_link', function ($row) {
                return '<a href="#"  data-toggle="modal" class="change_name" data-uid=' . $row->id . '>' . $row->name . '</a>';
            })
            ->addColumn('designation_link', function ($row) {
                return '<a href="#"  data-toggle="modal" class="change_designation" data-uid=' . $row->id . '>' . $row->designation . '</a>';
            })
            ->addColumn('office_link', function ($row) {
                return '<a href="#"  data-toggle="modal" class="change_office" data-uid=' . $row->id . '>' . $row->office . '</a>';
            })
            ->addColumn('date_of_birth_link', function ($row) {
                return '<a href="#"  data-toggle="modal" class="change_birthdate" data-uid=' . $row->id . '>' . $row->date_of_birth . '</a>';
            })

            ->addColumn('ddocardex', function ($row) {
                return $row->cardex_no . '/' . $row->ddo_code;
            })
            ->addColumn('changedetails', function ($row) {
                return '<button type="button" class="btn btn-sm btn-primary changedetails-btn" 
                data-id="' . base64_encode($row->id) . '" 
                data-dcode="' . base64_encode($row->dcode) . '" 
                data-tcode="' . base64_encode($row->tcode) . '" 
                data-ddo_code="' . base64_encode($row->ddo_code) . '" 
                data-cardex_no="' . base64_encode($row->cardex_no) . '">
                Change Details
            </button>';
            })
            ->rawColumns(['action', 'id', 'name_link', 'date_of_birth_link', 'designation_link', 'office_link', 'changedetails', 'ddocardex'])
            ->make(true);
    }
    public function designationselection_old(Request $request)
    {
        $officedesignation = $request->get('officedesignation');
        $temp = explode(':', $officedesignation);
        $validator = \Validator::make($request->all(), [
            'officedesignation' => 'required',


        ], [
            'officedesignation.required' => 'Office selection is required.',
        ]);
        if ($validator->fails()) {
            return response()->json(
                [
                    'success' => false,
                    'message' => $validator->errors()->all()
                ]
            );
        }
        $dlevel = DB::table('master.designationlevel')->where('designationcode', '=', $temp[1])->select('level')->first();
        if (!$dlevel)
            $dlevel1 = "4";
        else
            $dlevel1 = $dlevel->level;
        \Session::put('s_level', $dlevel1);

        return redirect('home');
    }
    public function designationselection(Request $request)
    { //dd($request);
        //   dd($request->all());
        $officedesignation = $request->get('officedesignation');
        $tempval = explode(':', $officedesignation);
        // dd($tempval);
        Session::put('empname', strip_tags($tempval[0]));
        Session::put('officecode', strip_tags($tempval[1]));
        Session::put('designationcode', strip_tags($tempval[2]));
        Session::put('districtcode', strip_tags($tempval[3]));
        Session::put('officeeng', strip_tags($tempval[4]));
        Session::put('desigeng', strip_tags($tempval[5]));
        Session::put('districteng', strip_tags($tempval[6]));
        Session::put('deptid', strip_tags($tempval[7]));
        //Session::put('officecode',28083); set manual in live to fetch records properly

        $validator = \Validator::make($request->all(), [
            'officedesignation' => 'required',


        ], [
            'officedesignation.required' => 'Office selection is required.',
        ]);
        if ($validator->fails()) {
            return response()->json(
                [
                    'success' => false,
                    'message' => $validator->errors()->all()
                ]
            );
        } //dd($tempval[2]);
        $dlevel = DB::table('master.designationlevel')->where('designationcode', '=', $tempval[2])->select('level')->first();
        if (!$dlevel)
            $dlevel1 = "4";
        else
            $dlevel1 = $dlevel->level;
        \Session::put('s_level', $dlevel1);
        //dd(Session::all());

        return redirect('home');
    }
    public function checkuser()
    {

        if (Auth::user()->is_admin == true) {
            $uid = Auth::user()->id;
            $office_designations = DB::table('user_office_designation')->where('uid', '=', $uid)->where('user_office_designation.active', '=', 1)
                ->select('user_office_designation.officecode', 'user_office_designation.designationcode', 'offices.name as officename', 'designations.name as designation')
                ->leftJoin('offices', 'user_office_designation.officecode', '=', 'offices.id')
                ->leftJoin('designations', 'user_office_designation.designationcode', '=', 'designations.id')
                ->get();
            dd($office_designations);
            return view('checkuser', ['office_designations' => $office_designations]);
        } else {

            return redirect('userdashboard');
        }
    }
    /*  public function index(UsersDataTable $dataTable)
    {
        $this->_viewContent['page_title'] = "User";
        return $dataTable->render('user.index',$this->_viewContent);
    }

    public function store(UsersDataTablesEditor $editor)
    {
        return $editor->process(request());
    }*/
    public function reset(Request $request, $field)
    {  //dd($request);
        $uid = $request->input('uid');
        $fieldType = $field; // This parameter is passed from the route

        $rules = [
            'field_value' => 'required',
        ];

        $validator = \Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect('user')
                ->withInput()
                ->withErrors($validator);
        }

        try {
            $updateData = [
                $fieldType => $request->input('field_value'),
            ];

            if ($fieldType === 'password') {
                $updateData[$fieldType] = Hash::make($request->input('field_value'));
            }

            $existingUser = \DB::table('userschema.users')->where('id', $uid)->first();

            if ($existingUser) {
                // 2️ Convert stdClass to array
                $userData = (array) $existingUser;
                // dd($userData);

                $userData = array_merge($userData, [
                    'updated_from' => $request->ip(),   // client IP
                    'updated_by'   => auth()->id(),      // logged-in user id
                ]);
                // dd($userData);
                // 3️ Insert into users_history
                    \DB::table('userschema.users_history')->insert($userData);

            } else {
                // Handle case where user not found
                return back()->with('error', 'User not found.');
            }

            \DB::table('userschema.users')
                ->where('id', $uid)
                ->update($updateData);

            $successMessage = ucfirst($fieldType) . ' changed successfully';
            return redirect('user')->with('success', $successMessage);
        } catch (\Exception $e) {  //echo $e->getMessage();exit;
            return redirect('user')->with('failed', 'Operation failed');
        }
    }
    public function getOtp(Request $request)
    {
        $query = DB::table('userschema.otps');

        if ($request->filled('id')) {
            $query->where('user_id', $request->id);
        }

        if ($request->filled('email')) {
            $uid = DB::table('userschema.users')
                ->where('email', $request->email)
                ->value('id');   // returns single id

            if ($uid) {
                $query->where('user_id', $uid);
            }
        }

        if ($request->filled('mobile')) {
            $query->where('mobile_no', $request->mobile);
        }

        $otpData = $query
            ->select('user_id', 'otp')
            ->orderByDesc('id')
            ->first();

        return response()->json([
            'user_id' => $otpData->user_id ?? null,
            'otp'     => $otpData->otp ?? null,
        ]);
    }
}
