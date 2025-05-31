<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Yajra\Datatables\Datatables;
use DB;
use App\Tquarterrequestb;
use App\Tquarterrequesta;
use App\User;
use App\QuarterType;
use App\Filelist;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Redirect;

class ReportsController extends Controller
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
    {     $this->_viewContent['page_title'] = "Dashboard";
        return view('admin/dashboard',$this->_viewContent);
    }
    public function waitinglist()
    {
        $this->_viewContent['page_title'] = "Waiting List";
        $officecode = Session::get('officecode');
      //  $this->_viewContent['quartertype']=DB::table('master.m_quarter_type')->select(['quartertype'])->orderBy('priority')->get();
       // $this->_viewContent['quartertype']=DB::table('master.m_quarter_type')->orderBy('priority')->pluck('quartertype','quartertype')->all();
        $this->_viewContent['quartertype']=DB::table('master.m_quarter_type')->where('officecode',$officecode)->orderBy('priority')->pluck('quartertype','quartertype')->all();

        return view('report/waitinglist',$this->_viewContent);
    }
    public function getWaitingList(request $request)
    {
        $quartertype = $request->quartertype;
$officecode = Session::get('officecode');
//dd($officecode);
// First query for "New" request type
$first = Tquarterrequesta::select([
    DB::raw("'New' as requesttype"),
    DB::raw("'New' as tableof"),
    'requestid', 'wno', 'inward_no', 'inward_date', 'u.name', 'u.designation', 'quartertype', 'office', 
    'rivision_id', 'date_of_retirement', 'contact_no', 'address', 'gpfnumber', 'is_accepted', 'is_allotted',
    'is_varified', 'email', 'u.id', 'r_wno', 'office_email_id', 'office_remarks', 'withdraw_remarks', 'officecode'
])
->join('userschema.users as u', 'u.id', '=', 'master.t_quarter_request_a.uid');

// Second query for "Higher Category" request type
$union = Tquarterrequestb::select([
    DB::raw("'Higher Category' as requesttype"),
    DB::raw("'Higher Category' as tableof"),
    'requestid', 'wno', 'inward_no', 'inward_date', 'u.name', 'u.designation', 'quartertype', 'office', 
    'rivision_id', 'date_of_retirement', 'contact_no', 'address', 'gpfnumber', 'is_accepted', 'is_allotted',
    'is_varified', 'email', 'u.id', 'r_wno', 'office_email_id', 'office_remarks', 'withdraw_remarks', 'officecode'
])
->join('userschema.users as u', 'u.id', '=', 'master.t_quarter_request_b.uid')
->union($first);

// Main query with conditional whereIn clause
$query = DB::table(DB::raw("({$union->toSql()}) as x"))
    ->select([
        'requesttype', 'tableof', 'requestid', 'wno', 'inward_no', 'inward_date', 'name', 'designation', 
        'quartertype', 'office', 'rivision_id', 'date_of_retirement', 'contact_no', 'address', 'gpfnumber', 
        'is_accepted', 'is_allotted', 'is_varified', 'email', 'id', 'r_wno', 'office_email_id', 'office_remarks', 
        'withdraw_remarks', 'officecode'
    ])
    ->where(function ($query) use ($officecode, $quartertype) {
        $query->where('is_accepted', '=', 1)
            ->where('is_allotted', '=', 0)
            ->where('is_varified', '=', 1);
          //  ->where('officecode', '=', $officecode);
        
        // Add whereIn only if $quartertype is not empty
        if (!empty($quartertype)) {
            $query->whereIn('quartertype', $quartertype);
        }

        $query->orderBy('wno');
    });
        // Apply global search
        if ($request->has('search') && $request->input('search')) {
            $search = $request->input('search');
            $search= $search['value'];
            $query->where(function ($query) use ($search) {
                $query->where('requesttype', 'like', "%$search%")
                      ->orWhere('tableof', 'like', "%$search%")
                      ->orWhere('inward_no', 'like', "%$search%")
                      ->orWhere('name', 'like', "%$search%")
                      ->orWhere('quartertype', 'like', "%$search%")
                      ->orWhere('office', 'like', "%$search%")
                      ->orWhere('date_of_retirement', 'like', "%$search%")
                      ->orWhere('contact_no', 'like', "%$search%")
                      ->orWhere('address', 'like', "%$search%")
                      ->orWhere('office_email_id', 'like', "%$search%")
                      ->orWhere('email', 'like', "%$search%")
                      ->orWhere('designation', 'like', "%$search%");
            });
        }
        
        return Datatables::of($query)
        ->addColumn('inward_date', function ($date) {
            if($date->inward_date=='')  return 'N/A';

            return date('d-m-Y',strtotime($date->inward_date));
        })
        ->addColumn('date_of_retirement', function ($date) {
            if($date->date_of_retirement=='')  return 'N/A';

            return date('d-m-Y',strtotime($date->date_of_retirement));
        })

        ->addColumn('action', function($data) {
            return '
                <button type="button" data-uid="'.$data->id.'" data-type="'.$data->tableof.'" data-rivision_id="'.$data->rivision_id.'"  data-requestid="'.$data->requestid.'" data-toggle="modal"  class=" btn-view-custom getdocument" > View</button>';
        })
        ->addColumn('office_remarks', function($row){


            if($row->office_remarks == "" )
            {

                    $link = 'onclick="show_dialog_desig(' . $row->id . ',' . $row->wno . ",'" . $row->quartertype . "')\"";
                    return "<a href='#'  ".$link."  class='desig_popup charcher_data btn-remark-custom'>Add Remarks</a>";
                    return $row->office_remarks;
            }
            else
            {

                return $row->office_remarks;
            }

        })
        ->rawColumns(['action','office_remarks'])
        ->filter(function ($instance) use ($request) {
            $search = $request->quartertype;
            if (!empty($search)) {
                $instance->where(function($w) use($request){
                    $search = $request->quartertype;
                    $w->orwhereIn('quartertype', $search);


                });
            }
        })
        ->setRowClass(function ($row) {
            if (strtotime($row->date_of_retirement) < strtotime(date('Y-m-d')) || $row->office_remarks != '') {

            return 'bg-light-pink';
            } else {
                return '';
            }
        })->make(true);

    }
    public function allotmentlist()
    {
        $this->_viewContent['page_title'] = "Allotment List";
        $this->_viewContent['quartertype']=DB::table('master.m_quarter_type')->orderBy('priority')->pluck('quartertype','quartertype')->all();
        return view('report/allotmentlist',$this->_viewContent);

    }
    public function getAllotmentList()
    {
       //   dd($request->quartertype);
     //  dd('hello');


    }
    public function vacantlist()
    {
        $this->_viewContent['page_title'] = "Vacant Quarter List";
         return view('report/vacantlist',$this->_viewContent);
    }
    public function getVacantList()
    {
        $data = DB::table('master.m_quarters')->select(['quartertype', 'building_no','master.m_area.areaname','block_no','unit_no',
        'floor','master.m_occupancy_type.name'])
        ->join('master.m_occupancy_type', 'master.m_occupancy_type.typecode', '=', 'master.m_quarters.occupay')
        ->join('master.m_area', 'master.m_area.areacode', '=', 'master.m_quarters.areacode')
        ->Where('occupay', '!=', 1);
        return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('floor', function ($row) {
                    if($row->floor=='FF')  return 'First Floor';
                    elseif($row->floor=='SF')
                    return 'Second Floor';
                   else
                   return 'Ground Floor';
                })
                ->addColumn('action', function($row){
                    return   '<input type="checkbox" class="form-check-input" value="'.$row->building_no.'" name="quartertype[]">';
                })
                ->filterColumn('quartertype', function($query, $keyword) {
                    $query->whereRaw("quartertype like ?", ["%{$keyword}%"]);
                })
                ->make(true);

    }
    public function quarteroccupancy(request $request)
    {
        $this->_viewContent['page_title'] = "Quarter Occupay";
        return view('report/quarteroccupay',$this->_viewContent);

    }
    public function  getquarteroccupancy()
    {
        $data = DB::table('master.t_quarter_allotment')->select(['qaid', 'areaname','quartertype','building_no','name',
        'allotment_date','occupancy_date','image'])
        ->join('master.m_area', 'master.m_area.areacode', '=', 'master.t_quarter_allotment.areacode')
        ->join('userschema.users as u', 'u.id', '=', 'master.t_quarter_allotment.uid');

        //$data->orderBy('r_wno', 'asc');
        return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('occupancy_date', function ($date) {
                    if($date->occupancy_date=='')  return 'N/A';

                    return date('d-m-Y',strtotime($date->occupancy_date));
                })
                ->addColumn('allotment_date', function ($date) {
                    if($date->allotment_date=='')  return 'N/A';

                    return date('d-m-Y',strtotime($date->allotment_date));
                })
                ->addColumn('image', function ($data) {
                    $url = url('/uploads/'.$data->image);
                 return "<img src='{$url}'  height='40' width='40'>";
                })
            ->filterColumn('quartertype', function($query, $keyword) {
                    $query->whereRaw("quartertype like ?", ["%{$keyword}%"]);
                })
                ->rawColumns(['image'])
                ->make(true);

    }
    public function upadteremarks(request $request)
    {
        try {
            $uid = $request['uid'];
            $wno = $request['wno'];
            $quartertype = $request['quartertype'];
            $office_remarks = $request['office_remarks'];

            // Update for existing user in request table a and b
            $requestA = Tquarterrequesta::where('quartertype', $quartertype)
                ->where('is_priority', 'N')
                ->where('uid', $uid)
                ->whereNotNull('wno')
                ->update([
                    'r_wno' => null,
                    'office_remarks' => $office_remarks
                ]);

            $requestB = Tquarterrequestb::where('quartertype', $quartertype)
                ->where('is_priority', 'N')
                ->where('uid', $uid)
                ->whereNotNull('wno')
                ->update([
                    'r_wno' => null,
                    'office_remarks' => $office_remarks
                ]);

            // Update query for set revise waiting list number null
            DB::transaction(function () use ($quartertype) {
                Tquarterrequesta::where('quartertype', $quartertype)
                    ->where('is_priority', 'N')
                    ->whereNotNull('wno')
                    ->update(['r_wno' => null]);

                Tquarterrequestb::where('quartertype', $quartertype)
                    ->where('is_priority', 'N')
                    ->whereNotNull('wno')
                    ->update(['r_wno' => null]);
            });

            // Select query for the set r_wno
            $requestAObj = DB::table('master.t_quarter_request_a')
                ->select('wno', 'uid', 'office_remarks')
                ->where('quartertype', $quartertype)
                ->where('is_priority', 'N')
                ->whereNotNull('wno')
                ->where('is_withdraw', 'N')
                ->whereNull('office_remarks')
                ->union(function ($query) use ($quartertype) {
                    $query->select('wno', 'uid', 'office_remarks')
                        ->from('master.t_quarter_request_b')
                        ->where('quartertype', $quartertype)
                        ->where('is_priority', 'N')
                        ->whereNotNull('wno')
                        ->where('is_withdraw', 'N')
                        ->whereNull('office_remarks');
                })
                ->orderBy('wno')
                ->get();
            // Foreach loop for setting r_wno
            foreach ($requestAObj as $req) {
                $uid = $req->uid;
                $r_wno= $req->wno;
                $today = date('Y-m-d');
                $dataToLog = "Iteration $uid: Some data";
              // Write data to custom log file
                Log::channel('custom_channel')->info($dataToLog);
               $retirementObj = User::select('id', 'email')
                    ->where('id', $uid)
                    ->where('date_of_retirement', '<', $today)->first();
                    Log::channel('custom_channel')->info($retirementObj);
                    if ($retirementObj === null) {
                        $quarterTypeInstance = new QuarterType();
                        $wno = $quarterTypeInstance->getNextRWno($quartertype);
                          // Your Eloquent query executed by using get()
                            // dd(\DB::getQueryLog());
                             //dd($wno);
                             $dataToLog = "last wainting   $wno: Some data";
                             Log::channel('custom_channel')->info($dataToLog);
                        TQuarterRequesta::where('quartertype', $quartertype)
                            ->where('is_priority', 'N')
                            ->whereNotNull('wno')
                            ->where('wno', $r_wno)
                            ->update(['r_wno' => $wno]);

                        TQuarterRequestb::where('quartertype', $quartertype)
                            ->where('is_priority', 'N')
                            ->whereNotNull('wno')
                            ->where('wno', $r_wno)
                            ->update(['r_wno' => $wno]);

                    } else {
                        TQuarterRequesta::where('quartertype', $quartertype)
                        ->where('is_priority', 'N')
                        ->whereNotNull('wno')
                        ->where('uid', $uid)
                        ->update(['r_wno' => null]);

                    TQuarterRequestb::where('quartertype', $quartertype)
                        ->where('is_priority', 'N')
                        ->whereNotNull('wno')
                        ->where('uid', $uid)
                        ->update(['r_wno' => null]);
                    }

                /*if ($retirementObj->isNotEmpty()) { dd($retirementObj);
                    $uid = $retirementObj['id'];
                    TQuarterRequesta::where('quartertype', $quartertype)
                        ->where('is_priority', 'N')
                        ->whereNotNull('wno')
                        ->where('uid', $uid)
                        ->update(['r_wno' => null]);

                    TQuarterRequestb::where('quartertype', $quartertype)
                        ->where('is_priority', 'N')
                        ->whereNotNull('wno')
                        ->where('uid', $uid)
                        ->update(['r_wno' => null]);


                } else {
                    // Set rwno
                     // \DB::enableQueryLog(); // Enable query log
                      $quarterTypeInstance = new QuarterType();
                      $wno = $quarterTypeInstance->getNextRWno($quartertype);
                        // Your Eloquent query executed by using get()
                          // dd(\DB::getQueryLog());
                           //dd($wno);

                      TQuarterRequesta::where('quartertype5', $quartertype)
                          ->where('is_priority', 'N')
                          ->whereNotNull('wno')
                          ->where('wno', $r_wno)
                          ->update(['r_wno' => $wno]);

                      TQuarterRequestb::where('quartertype5', $quartertype)
                          ->where('is_priority', 'N')
                          ->whereNotNull('wno')
                          ->where('wno', $r_wno)
                          ->update(['r_wno' => $wno]);

                }*/
            }

            return Redirect::route('waiting.list')->with('success', 'Watinglist Update Successfully');
        } catch (\Exception $e) {
           // dd($e->getMessage());
            // Handle any exceptions here
            return Redirect::route('waiting.list')->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
    public function vacant_quarter(request $request){

        $data = DB::table('master.m_quarters')
        ->whereIn('building_no',$request->category)
        ->update(['occupay' => 1]);
        $data1 = DB::table('master.t_quarter_allotment')
       ->whereIn('building_no',$request->category)
       ->delete();
       if($data)
       {
           return json_encode("successfully");
       }
       else{
       return json_encode("failer");
       }
    }
    public function getdocumentdata(request $request)
    {
        $performa='';
        if($request->type=='New')
        {
            $performa='a';
        }
        else
        {
            $performa='b';
        }

        $first = Filelist::select(['rev_id','doc_id','document_name'])
        ->join('master.m_document_type as  d', 'd.document_type', '=', 'master.file_list.document_id')
        ->Where('uid', '=', $request->uid)
        ->Where('request_id', '=', $request->requestid)
        ->Where('master.file_list.performa', '=', $performa)
        ->Where('rivision_id', '=', $request->rivision_id)
        ->get();
        //dd($first);
        $html = '<table border="1" width="100%" class="table"><thead><tr><th>Document Name</th><tr></thead>';
        foreach ($first as $f) {
                $downloadUrl = route('download_file', ['filename' => $f->doc_id]);

                $html .= '<tr>
                    <td>
                        <a href="' . $downloadUrl . '" 
                        target="_blank" 
                        doc_id="' . htmlspecialchars($f->doc_id) . '" 
                        rev_id="' . htmlspecialchars($f->rev_id) . '">
                            ' . htmlspecialchars($f->document_name) . '
                        </a>
                    </td>
                </tr>';
            }
        $html .= '</table>';
        echo $html;

    }
    public function download(request $request){
      //  dd($request);
     // echo   Request::segment(1);
    }
    public function html() {
        return $this->builder()
                    ->columns($this->getColumns())
                    ->parameters([
                        'buttons' => ['export'],
                    ]);
    }

}
