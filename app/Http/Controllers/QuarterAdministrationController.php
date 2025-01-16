<?php

namespace App\Http\Controllers;
use App\Area;
use Yajra\Datatables\Datatables;
use Illuminate\Http\Request;

class QuarterAdministrationController extends Controller
{
    //
    public function index()
    {    
	    $this->viewContent['page_title'] = trans('area.quartertypeadministration');
        return View('master.quartertypeadministration.index', $this->viewContent);
    }
    public function getList(Request $request)
    {
        $data = Area::select(['areaname', 'address', 'address_g','areaid','areacode']);
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $actionBtn = '<a href="javascript:void(0)" class="edit btn btn-success btn-sm editArea" data-id="' . $row->areacode . '">Edit</a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm delete deleteArea" destroy-id="' . $row->areaid . '">Delete</a>';
                return $actionBtn;
            })
            ->rawColumns(['action'])
            ->make(true);

    }
}
