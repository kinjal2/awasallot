<?php

namespace App\Http\Controllers;

use Request;
use App\Tquarterrequestb;
use App\Tquarterrequesta;
use App\Tquarterrequestc;
use Yajra\Datatables\Datatables;
use DB;
class QuartersPriorityController extends Controller
{
    //
    public  function index()
    {
        $this->_viewContent['page_title'] = "Quarter Priority";
        return view('priority/index',$this->_viewContent);
    }
    public function getList(request $request)
    {
        $first = Tquarterrequesta::from('master.t_quarter_request_a AS a')->select(['request_date',DB::raw("'a'::text as type"),DB::raw("'New'::text as requesttype"),'requestid','quartertype','inward_no','inward_date','u.name','u.designation','office','rivision_id','a.remarks','contact_no',
        'address','gpfnumber','is_accepted','is_allotted','is_varified','email','is_priority','wno','uid'])
        ->join('userschema.users as u', 'u.id', '=', 'a.uid');
      
      $second = Tquarterrequestc::from('master.t_quarter_request_c AS c')->select(['request_date',DB::raw("'c' as type"),DB::raw("'Change' as requesttype"),'requestid','quartertype','inward_no','inward_date','u.name','u.designation','office','rivision_id','c.remarks','contact_no',
        'address','gpfnumber','is_accepted','is_allotted','is_varified','email','is_priority', DB::raw('CAST(wno AS integer)'),'uid'])
        ->join('userschema.users as u', 'u.id', '=', 'c.uid')
        ;
      $union =Tquarterrequestb::from('master.t_quarter_request_b AS b')->select(['request_date',DB::raw("'b'::text as type"),DB::raw("'Higher Category'::text  as requesttype"),'requestid','quartertype','inward_no','inward_date','u.name','u.designation','office','rivision_id','b.remarks','contact_no',
        'address','gpfnumber','is_accepted','is_allotted','is_varified','email','is_priority','wno','uid']) 
        ->join('userschema.users as u', 'u.id', '=', 'b.uid')
        ->union($first)
        ->union($second);

    $query = DB::table(DB::raw("({$union->toSql()}) as x"))
        ->select(['type','requesttype','requestid','quartertype','inward_no','inward_date','name','designation','office','rivision_id','remarks','contact_no',
        'address','gpfnumber','is_accepted','is_allotted','is_varified','email','request_date','is_priority','wno','uid'])
        ->where(function ($query) {
            $query->where('is_accepted', '=', 1)
          //  ->WhereNull('remarks')
           // ->Where('is_varified', '=', 0)
            ->Where('is_priority', '=', 'Y')
            ->orderBy('wno'); 
        });
       
        
       // echo $query->toSql(); 
    return Datatables::of($query)
    
    ->addColumn('request_date', function ($date) {
        if($date->request_date=='')  return 'N/A';
      
        return date('d-m-Y',strtotime($date->request_date));
    })
   
    ->addColumn('action', function($row){
      //  $btn1 =   "edit";                  
        
      $btn1 = '<a href="'.\route('editquarter_a', ['r' => $row->requestid, 'rv' => $row->rivision_id]).'" class=" btn-edit-custom ">Edit</a>';
      return $btn1;
     })
     ->addColumn('delete', function($row){
         $btn1 ='<a href="javascript:void(0)" class=" btn-delete-custom"  uid="' . $row->uid . '"  type="' . $row->type . '"  rev-id="' . $row->rivision_id . '" destroy-id="' . $row->requestid . '">Delete</a>';
         return $btn1;
     })
     ->rawColumns(['delete','action'])
    ->make(true);

    }
    public  function destroy(request $request)
    {
        $result1 = json_encode($request::all(), true);
        $result1 = json_decode($result1, true);
        $type= $result1['type'];
        $requestid=$result1['id'];
        $rv= $result1['rev'];
        $uid= $result1['uid'];
       if($type=='a')
        $tquarterrequesta = tquarterrequesta::Where('requestid', '=', $requestid)->Where('uid', '=', $uid)->Where('rivision_id', '=', $rv)->delete();
     
          
    }
}
