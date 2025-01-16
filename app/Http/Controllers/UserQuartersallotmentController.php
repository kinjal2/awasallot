<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tquarterallotment;
use Session;
use Yajra\Datatables\Datatables;
use DB;
class UserQuartersallotmentController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {    
	    $this->_viewContent['page_title'] = "Quarter Allotment" ;
        return view('quarterallotment/index',$this->_viewContent);
    }
    public function getList(Request $request)
    {
        $data = Tquarterallotment::select(['quartertype', 'areaname', 'request_type', 'block_no', 'unitno', 'renttypename','master.t_quarter_allotment.renttypeid','db_field' ])
        ->join('master.m_area', 'master.m_area.areacode', '=', 'master.t_quarter_allotment.areacode')
        ->join('master.m_renttype', 'master.m_renttype.renttypeid', '=', 'master.t_quarter_allotment.renttypeid');
    //    ->join('master.m_quarter_type', 'd', '=', 'master.m_renttype.db_field');
     
        return Datatables::of($data)
            ->addIndexColumn()
           
            ->make(true);

    }

}
