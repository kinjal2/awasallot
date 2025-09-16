<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    //  $this->middleware(['auth','verified','verifiedphone']);
    // $this->middleware(function ($request, $next) {
    //   $user = Auth::user();
    //   if (Auth::check() && (Auth::user()->is_admin == false || empty(Auth::user()->is_admin))) {
    //       $this->middleware(['auth', 'verified', 'verifiedphone']);
    //   }
    //   else{
    //     $this->middleware(['auth']);
    //   }
    //   return $next($request);
    // });
    //    $this->middleware(['auth']);
  }
  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function index()
  {
    //echo "hi";dd(Auth::user());exit;
    if (Auth::check() && Auth::user()->is_admin == true) {
      return  \Redirect::route('admin.dashboard.admindashboard');
      // return \Redirect('/checkuser');
    } else {
      return  \Redirect::route('user.dashboard.userdashboard');
    }
  }
 
}
