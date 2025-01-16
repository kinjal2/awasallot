<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\QuarterType;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Session;

class QuarterTypeController extends Controller
{
    //
    public function index()
    {
        $this->viewContent['page_title'] = trans('categories.Categories');
        //$this->viewContent['success'] = \Session::get('success');
        return View('master.quartertype.index', $this->viewContent);
    }
    public function getList(Request $request)
    {
        $data = QuarterType::select(['quartertype', 'bpay_from', 'bpay_to', 'rent_normal', 'rent_standard', 'rent_economical', 'rent_market', 'priority', 'officecode']);
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                //$actionBtn = '<a href="javascript:void(0)" class="btn-edit-custom">Edit</a> <a href="javascript:void(0)" class="btn-delete-custom" destroy-id="' . $row->priority . '">Delete</a>';
                //$actionBtn = "<a href='".route('masterquartertype.editQuarterType', ['officecode' => base64_encode($row->officecode)]) ."' class='edit btn btn-success btn-sm editArea' data-officecode='" . base64_encode($row->officecodcode) . "'>Edit</a> <a href='javascript:void(0)' class='delete btn btn-danger btn-sm delete deleteArea' destroy-id='" . $row->officecode . "'>Delete</a>";
                $actionBtn = "<a href='" . route('masterquartertype.editQuarterType', ['officecode' => base64_encode($row->officecode), 'quartertype' => base64_encode($row->quartertype)]) . "' class='edit btn btn-success btn-sm editArea' data-officecode='" . base64_encode($row->officecodcode) . "' data-quartertype='" . base64_encode($row->quartertype) . "'>Edit</a> <a href='javascript:void(0)' class='delete btn btn-danger btn-sm delete deleteArea' destroy-id='" . $row->officecode . "'>Delete</a>";
                return $actionBtn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    public function destroy(Request $request)
    {
        echo "bhgfh";
    }
	public function addQuarterType()
    {
        $this->viewContent['page_title'] = trans('area.quartertype');

        //$this->viewContent['success'] = \Session::get('success');
        return view('master.quartertype.addQuarterType', $this->viewContent);
    }							
    public function editQuarterType($officecode, $quartertype)
    {
        $editofficcode = base64_decode($officecode);
        $editquartertype = base64_decode($quartertype);
        //  $QuarterType = QuarterType::where('officecode',$editofficcode)->first();
        $QuarterType = QuarterType::where('officecode', $editofficcode)->where('quartertype', $editquartertype)->first();


        $this->viewContent['page_title'] = trans('area.quartertype');
        $this->viewContent['quartertype'] = $QuarterType;
        //$this->viewContent['success'] = \Session::get('success');
        return View('master.quartertype.editQuarterType', $this->viewContent);
    }
    public function store(Request $request)
    {

        try{
        // Ensure that both keys are present in the request
        if (!isset($request->officecode) || !isset($request->quartertype)) {
            return response()->json(['message' => 'Office code and quarter type are required.'], 400);
        }

        // Decode the composite key values from the request
        $officecode = base64_decode($request->officecode);
        $quartertype = base64_decode($request->quartertypeh);

        // Update the record using the composite keys
        $updated = QuarterType::where('officecode', $officecode)
            ->where('quartertype', $quartertype)
            ->update([
                'quartertype_g' => $request->quartertype_g,
                'bpay_from' => $request->bpay_from,
                'bpay_to' => $request->bpay_to,
                'rent_normal' => $request->rent_normal,
                'rent_standard' => $request->rent_standard,
                'rent_economical' => $request->rent_economical,
                'rent_market' => $request->rent_market,
                'remarks' => $request->remarks,
                'priority' => $request->priority,
                'updatedby' => Session::get('uid'),
                'updatedon' => now(),
            ]);

        // Check if the update was successful
        if ($updated) {
            $quartertype=QuarterType::where('officecode', $officecode)
            ->where('quartertype', $quartertype)->first();
            return response()->json(['success' => 'Record updated successfully.']);
           // return redirect(route('masterquartertype.editQuarterType', ['officecode' => base64_encode($officecode), 'quartertype' => base64_encode($quartertype)]));
        } else {
            return response()->json(['error' => 'Record not found or no changes made.'], 404);
        }
     }
     catch(Exception $e)
     {
        return response()->json(['success' => false, 'message' => "ERROR: " . $e->getMessage() . " (" . $e->getCode() . ")"]);
     }
    }
    public function storenew(Request $request)
    {
        try {
            // Validate the incoming request data
            $validatedData = $request->validate([
                'quartertype' => 'required|string|max:255',
                'quartertype_g' => 'nullable|string|max:255',
                'bpay_from' => 'required|numeric',
                'bpay_to' => 'required|numeric',
                'rent_normal' => 'required|numeric',
                'rent_standard' => 'required|numeric',
                'rent_economical' => 'required|numeric',
                'rent_market' => 'required|numeric',
                'remarks' => 'nullable|string|max:1000',
                'priority' => 'required|integer',
                
            ]);
           
            //check if already exists
            $data = QuarterType::where('officecode', 28083)
                ->where('quartertype', $validatedData['quartertype'])->first();
                // echo "<pre>";
                // print_r($data);
                // die;
                
            if($data==null){
                //dd($data);
            // Create a new QuarterType record
            $quarterType = QuarterType::create([
                'officecode' =>'28083',
                'quartertype' => $validatedData['quartertype'],
                'quartertype_g' => $validatedData['quartertype_g'],
                'bpay_from' => $validatedData['bpay_from'],
                'bpay_to' => $validatedData['bpay_to'],
                'rent_normal' => $validatedData['rent_normal'],
                'rent_standard' => $validatedData['rent_standard'],
                'rent_economical' => $validatedData['rent_economical'],
                'rent_market' => $validatedData['rent_market'],
                'remarks' => $validatedData['remarks'],
                'priority' => $validatedData['priority'],
                'updatedon' => now(),
               
            ]);
            // Optionally, you can return a response or redirect
            return response()->json(['success' => 'Quarter Type created successfully!']);
        }
        else{
            //dd("already exists");
            return response()->json(['success' =>'Quarter Type already exists']);
        }
            
        } catch (Exception $e) {
            return response()->json(['error' => false, 'message' => "ERROR: " . $e->getMessage() . " (" . $e->getCode() . ")"]);
        }
    }

}
