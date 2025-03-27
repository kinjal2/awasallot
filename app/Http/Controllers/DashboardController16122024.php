<?php

namespace App\Http\Controllers;

use Validator,Redirect,Response;
use Session;
use App\User;
use App\Quarter;
use App\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\DDOCode;

class DashboardController extends Controller
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
       
	   $this->_viewContent['page_title'] = "Dashboard";
        return view('admin/dashboard',$this->_viewContent);
    }
    public function userdashboard()
    {
       
        $uid=Auth::user()->id;
       
        //to get ddo info
        $officecode = null;
        $usermaster = User::find($uid);
         //dd($usermaster);
         // Assuming the user has a 'cardex_no' attribute
         if ($usermaster) {
           // dd("hello");
            $officecode = DDOCode::where('cardex_no', $usermaster->cardex_no)
                           ->where('ddo_code', $usermaster->ddo_code)
                           ->pluck('officecode')
                           ->first(); // Access the related ddocode

            
            if ($officecode) {
                Session::put('officecode',$officecode);
                if($officecode!=28083)
                {
                    // q_officecode=28084 will be set for quarter type category if district is other than gandhinagar (that is for all districts other than gandhinagar)
                    Session::put('q_officecode',28084);
                }
                else
                {
                    Session::put('q_officecode',$officecode);
                }
            }
        }

        
        Session::put('Name',$usermaster->name);
        Session::put('Uid',$uid);
       if($usermaster->basic_pay=='')
        {
            return redirect('profile');
        }
        else{  //echo $usermaster->basic_pay;
            Session::put('basic_pay',$usermaster->basic_pay);

            $q_officecode=Session::get('q_officecode',$officecode);
//            dd($q_officecode);
          //  $this->_viewContent['quarterlist'] = Quarter::all(); 
           // $this->_viewContent['quarterlist'] = Quarter::all()->where('officecode',$q_officecode);
           $this->_viewContent['quarterlist'] = Quarter::where('officecode', $q_officecode)->get();
           //dd($this->_viewContent['quarterlist']);

            $this->_viewContent['notification'] = Notification::where('uid', '=',  $uid)->get();
            $basic_pay=Session::get('basic_pay');
            $this->_viewContent['quarterselect']= Quarter::where('bpay_from', '<=',$basic_pay)->where('bpay_to', '>=',$basic_pay)->where('officecode', $q_officecode)->first();

            $this->_viewContent['page_title'] = "Dashboard";
            return view('user/dashboard',$this->_viewContent); 
        }


      

    }
}
