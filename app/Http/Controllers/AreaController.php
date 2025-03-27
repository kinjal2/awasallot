<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Area;
use Yajra\Datatables\Datatables;
class AreaController extends Controller
{
    public function index()
    {
	    $this->viewContent['page_title'] = trans('area.area');
        //$this->viewContent['success'] = \Session::get('success');
        return View('master.area.index', $this->viewContent);
    }
    public function getList(Request $request)
    {
        $data = Area::select(['areaname', 'address', 'address_g','areaid','areacode']);
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $editUrl = route('masterarea.editArea', ['id' => $row->areacode]);

                //$actionBtn = '<a href="javascript:void(0)" class="edit btn btn-success btn-sm editArea" data-id="' . $row->areacode . '">Edit</a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm delete deleteArea" destroy-id="' . $row->areaid . '">Delete</a>';
                $actionBtn = "<a href='".route('masterarea.editArea', ['id' => base64_encode($row->areacode)]) ."' class='edit btn btn-success btn-sm editArea' data-id='" . $row->areacode . "'>Edit</a> <a href='javascript:void(0)' class='delete btn btn-danger btn-sm delete deleteArea' destroy-id='" . $row->areaid . "'>Delete</a>";
                return $actionBtn;

            })
            // ->addColumn('action', function($row){
            //     return '<a href="#"   class="edit btn btn-success btn-sm editArea" data-uid='.$row->areacode.'>Edit</a>';
            // })
            // ->addColumn('action', function($row){
            //         return '<a href="#"   class="delete btn btn-danger btn-sm delete deleteArea" destroy-id="' . $row->areacode . '">Delete</a>';
            //     })
            ->rawColumns(['action'])
            ->make(true);

    }
    public function addNewArea()
    {
        //$this->viewContent['page_title'] = "trans('area.area')";
        $this->viewContent['page_title'] = "Create New Area";
        //$this->viewContent['success'] = \Session::get('success');
        return view('master.area.addNewArea', $this->viewContent);
    }
    public function store(Request $request)
    {

        // Area::updateOrCreate(['areacode' => $request->area_id],
        //         ['areaname' => $request->areaname, 'address' => $request->address,'address_g' => $request->address_g,'officecode'=>28083]);

        //return response()->json(['success'=>'Area saved successfully.']);
        try {

            // Validate the request with rules and custom messages
             $request->validate([
            'areaname' => 'required|string|max:255|regex:/^[A-Za-z0-9\s]+$/',
            'address' => 'required|string|max:255|regex:/^[A-Za-z0-9\s,.-]+$/',
            'address_g' => 'required|string|max:255',
        ], [
            'areaname.required' => 'Area Name is required.',
            'areaname.regex' => 'The Area name may only contain letters, numbers and spaces.',
            'address.regex' => 'The address may only contain letters, numbers, spaces, and basic punctuation (.,-).',
            'address.required' => 'Address is required.',
            'address_g.required' => 'Address Gujarati is required.',
        ]);
        Area::updateOrCreate(
            ['areacode' => base64_decode($request->areacode)],
            ['areaname' => $request->areaname, 'address' => $request->address, 'address_g' => $request->address_g, 'officecode' => 28083]
        );

        return response()->json(['success' => 'Area saved successfully.']);
    } catch (Exception $e) {
        return response()->json(['success' => false, 'message' => "ERROR: " . $e->getMessage() . " (" . $e->getCode() . ")"]);
    }
    }

    /*public function edit($id)
    {

        $Area = Area::find($id);
        return response()->json($Area);

    }*/
    public function editArea($id)
    {
        $editid = base64_decode($id);
        $Area = Area::find($editid);
       // print_r($Area);
        //die();
        $this->viewContent['page_title'] = trans('area.area');
        $this->viewContent['area']=$Area;
        //$this->viewContent['success'] = \Session::get('success');
        return View('master.area.editArea', $this->viewContent);

    }
    public function destroy(Request $request, $id)
    {
        $check = Area::where('areaid', $id)->delete();
        return Response::json($check);
    }


}
