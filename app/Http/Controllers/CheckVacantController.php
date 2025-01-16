<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckVacantController extends Controller
{
    public function index()
    {
        $this->_viewContent['page_title'] = " Vacant Quarter List";
        return view('user/vacantquarter', $this->_viewContent);
    }
}
