<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestMail;
use App\Http\Controllers\PhoneVerificationController;
use App\Http\Controllers\FileDownloadController;
use App\Http\Controllers\DDOController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\QuarterTypeController;
use App\Http\Controllers\DdoUserLoginController;
use App\Http\Controllers\DDOUserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CheckVacantController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\QuartersController;
use App\QuarterType;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/send-test-email', function () {
    Mail::to('mohitupadhyay90@gmail.com')->send(new TestMail());
    return 'Test email sent 11dfd!';
});
Route::get('/', function () {
    return view('welcome');
});
Route::get('locale/{locale}', function ($locale){
    Session::put('locale', $locale);
    return redirect()->back();
});


Auth::routes();
Route::get('/grasapi', 'RegistrationController@apiLogin')->name('grasapi');
Auth::routes(['verify' => true]);
Route::get('phone/verify', [PhoneVerificationController::class, 'show'])->name('phoneverification.notice');
Route::post('phone/verify', [PhoneVerificationController::class, 'verify'])->name('phoneverification.verify');
Route::get('/home', ['uses' => 'HomeController@index', 'as' => 'home']);//->middleware('verifiedphone', 'verified');

Route::post('/designationselection', 'UserController@designationselection')->name('designationselection');
Route::get('/checkuser', 'UserController@checkuser')->name('checkuser');
Route::get('userdashboard', ['uses' => 'DashboardController@userdashboard', 'as' => 'user.dashboard.userdashboard'])->middleware('verifiedphone', 'verified');
Route::get('admindashboard', ['uses' => 'DashboardController@index', 'as' => 'admin.dashboard.admindashboard']);


//Route::get('dashboard', [ 'as' => 'admin.dashboard', 'uses' => 'DashboardController@index']);
//get profile
Route::get('profile', [ 'as' => 'user.profile', 'uses' => 'ProfileController@index'])->middleware('verifiedphone', 'verified');
Route::post('profiledetails', 'ProfileController@updateprofiledetails');
Route::post('profiledetails_email', 'ProfileController@updateprofiledetails_email');
Route::get('quartersuser', [ 'as' => 'user.Quarters', 'uses' => 'QuartersController@requestnewquarter']);
Route::post('savenewrequest', ['uses' => 'QuartersController@saveNewRequest']);
//3/1/2025
Route::post('saveOfficeCode', ['uses' => 'QuartersController@saveOfficeCode']);


Route::post('/salarySlabDetails', [ProfileController::class, 'getSalarySlabDetails'])->name('salarySlabDetails');

Route::get('quartershigher', [ 'as' => 'user.quarter.higher', 'uses' => 'QuartersController@requesthighercategory']);
Route::post('saveHigherCategoryReq', ['uses' => 'QuartersController@saveHigherCategoryReq']);

Route::get('quarterschange', [ 'as' => 'user.quarter.change', 'uses' => 'QuartersController@requestchange']);
Route::get('quartershistory', [ 'as' => 'user.quarter.history', 'uses' => 'QuartersController@index']);
Route::post('request-history', ['uses' => 'QuartersController@requestHistory']);

Route::get('/generate-pdf/{request_id}/{revision_id}/{performa}', 'QuartersController@generate_pdf')->name('generate.pdf');


Route::get('uploaddocument/:any', ['uses' => 'QuartersController@uploaddocument']);
Route::post('saveuploaddocument', ['uses' => 'QuartersController@saveuploaddocument']);
Route::post('deletedoc', ['uses' => 'QuartersController@deletedoc']);

Route::get('download/:any', [ 'as' => 'download.pdf', 'uses' => 'ReportsController@download']);
Route::get('quarters', [ 'as' => 'quarters', 'uses' => 'QuartersController@index']);
Route::get('quarterlistnormal', [ 'as' => 'quarter.list.normal', 'uses' => 'QuartersController@quarterlistnormal']);
Route::get('quarterlistnew', [ 'as' => 'quarter.list.new', 'uses' => 'QuartersController@quarterNewRequest']);
Route::post('saveapplication', [ 'as' => 'quarter.list.saveapplication', 'uses' => 'QuartersController@saveapplication']);
Route::post('saveapplication_b', [ 'as' => 'quarter.list.saveapplication_b', 'uses' => 'QuartersController@saveapplication_b']);
Route::post('saveremarks', [ 'as' => 'quarter.list.saveremarks', 'uses' => 'QuartersController@saveremarks']);
Route::get('/viewapplication/{request_id}/{revision_id}/{performa}', [ 'as' => 'quarter.list.viewapplication', 'uses' => 'QuartersController@viewApplication']);
Route::post('/get-document-url', [ 'as' => 'quarter.list.showDocument', 'uses' => 'QuartersController@showDocument']);
Route::post('savefinalannexure',['as'=>'quarter.final.annexure','uses'=>'QuartersController@saveFinalAnnexure']);



Route::get('waitinglist', [ 'as' => 'waiting.list', 'uses' => 'ReportsController@waitinglist']);

Route::get('allotmentlist', [ 'as' => 'allotment.list', 'uses' => 'ReportsController@allotmentlist']);
Route::get('vacantlist', [ 'as' => 'vacant.list', 'uses' => 'ReportsController@vacantlist']);
Route::post('waiting-list', [ 'as' => 'waitinglist.data','uses' => 'ReportsController@getWaitingList']);
Route::post('upadteremarks', [ 'as' => 'upadteremarks.data','uses' => 'ReportsController@upadteremarks']);



Route::post('getdocumentdata', [ 'as' => 'getdocumentdata','uses' => 'ReportsController@getdocumentdata']);



Route::post('allotment-list', ['as' => 'allotment-list', 'uses' => 'ReportsController@getAllotmentList']);
Route::post('vacant-list', ['as' => 'vacant-list', 'uses' => 'ReportsController@getVacantList']);

Route::post('normalquarter-list', ['as' => 'normalquarter-list', 'uses' => 'QuartersController@getNormalquarterList']);

Route::post('vacant_quarter', ['as' => 'vacant_quarter', 'uses' => 'ReportsController@vacant_quarter']);
Route::get('quarter-occupancy', ['as' => 'quarter.occupancy', 'uses' => 'ReportsController@quarteroccupancy']);
Route::get('quarter-police-document', ['as' => 'quarter.police.document', 'uses' => 'PolicestaffController@index']);
Route::post('policestaff-data', [ 'as' => 'policestaff.data','uses' => 'PolicestaffController@getpolicedocumentList']);
Route::get('editquarter_police_a/{r}/{rv}/{performa}', ['as' => 'editquarter_police_a', 'uses' => 'PolicestaffController@editquarter_a']);
Route::post('savepoliceapplication', [ 'as' => 'quarter.list.savepoliceapplication', 'uses' => 'PolicestaffController@saveapplication']);


Route::post('quarteroccupancylist', ['as' => 'quarter.occupancy.list', 'uses' => 'ReportsController@getquarteroccupancy']);

//Route::get('editquarter/{id}', ['as' => 'editquarter', 'uses' => 'QuartersController@editquarter']);
Route::get('editquarter_a/{r}/{rv}', ['as' => 'editquarter_a', 'uses' => 'QuartersController@editquarter_a']);
Route::get('editquarter_b/{r}/{rv}', ['as' => 'editquarter_b', 'uses' => 'QuartersController@editquarter_b']);
Route::get('download/{id}', ['as' => 'download', 'uses' => 'QuartersController@downloaddocument']);

Route::get('reports', [ 'as' => 'reports', 'uses' => 'ReportsController@index']);
Route::get('user', [ 'as' => 'user', 'uses' => 'UserController@index']);
Route::post('user-list', 'UserController@getList')->name('user.list');

Route::post('/resetpassword', 'UserController@resetpassword')->name('resetpassword');
Route::post('/resetname', 'UserController@resetname')->name('resetname');
Route::post('/resetdesignation', 'UserController@resetdesignation')->name('resetdesignation');
Route::post('/reset/{field}', 'UserController@reset')->name('reset');
//Route::get('users', [ 'as' => 'users', 'uses' => 'UserController@index']);

//quarter type
Route::get('masterquartertype', ['uses' => 'QuarterTypeController@index', 'as' => 'masterquartertype.index']);
Route::post('getList1','QuarterTypeController@getList');
Route::get('/editQuarterType/{officecode}/{quartertype}/edit',[QuarterTypeController::class,'editQuarterType'])->name('masterquartertype.editQuarterType');
Route::post('/editQuarterType',[QuarterTypeController::class,'store'])->name('masterquartertype.store');
Route::get('/addQuarterType',[QuarterTypeController::class,'addQuarterType'])->name('masterquartertype.addQuarterType');
Route::post('/addQuarterType',[QuarterTypeController::class,'storenew'])->name('masterquartertype.storenew');																																						   
Route::resource('masterquartertype', 'QuarterTypeController');


//area
Route::get('masterarea', ['uses' => 'AreaController@index', 'as' => 'masterarea.index']);
Route::post('getList','AreaController@getList');
Route::resource('masterarea', 'AreaController');
//Route::delete('masterarea/{id}', [AreaController::class, 'destroy'])->name('masterarea.destroy');
//Route::get('masterarea/{id}/edit', [AreaController::class, 'edit'])->name('masterarea.edit');
Route::get('/addNewArea',[AreaController::class,'addNewArea'])->name('masterarea.addNewArea');
Route::post('/addNewArea',[AreaController::class,'store'])->name('masterarea.store');
Route::get('/editArea/{id}/edit',[AreaController::class,'editArea'])->name('masterarea.editArea');
Route::post('/editArea',[AreaController::class,'store'])->name('masterarea.store');

//Quarters  adminadministration
// Route::get('quartertypeadministration', ['uses' => 'QuarterAdministrationController@index', 'as' => 'quartertypeadministration.index']);
// Route::post('getList','QuarterAdministrationController@getList');
// Route::resource('masterarea', 'QuarterAdministrationController');

Route::get('quarterlistpriority',['QuartersPriorityController@index','as'=>'quarterlistpriority.index']);
Route::post('getList2','QuartersPriorityController@getList');
Route::resource('quarterlistpriority', 'QuartersPriorityController');

// quarter allotment
Route::get('userallotmentlist',['UserQuartersallotmentController@index','as'=>'userallotmentlist.index']);
Route::post('getListallot','UserQuartersallotmentController@getList');
Route::resource('userallotmentlist', 'UserQuartersallotmentController');
//Route::get('logout', ['uses' => 'Auth\LoginController@Logout', 'as' => 'public.do.logout']);
Route::get('/logout', 'Auth\LoginController@logout');
//captcha code
Route::get('reload-captcha','Auth\RegisterController@reloadCaptcha')->name('reload-captcha');
//download file
Route::get('/download_file/{filename}', [FileDownloadController::class, 'showDoc'])->name('download_file');


//ddo
Route::get('/ddolist',[DDOController::class, 'index'])->name('ddo.list');
Route::post('/ddolist', [DDOController::class, 'show_ddolist'])->name('ddo.showlist');
//Route::post('/ddolist/store',[DDOController::class,'store'])->name('ddo.store');
Route::get('/addNewDDO',[DDOController::class,'addNewDDO'])->name('ddo.addNewDDO');
Route::post('/addNewDDO',[DDOController::class,'addNewDDOStore'])->name('ddo.store');

//Route::post('/getDDOCode',[RegisterController::class,'getDDOCode'])->name('ddo.getDDOCode');
Route::post('/getDDOCode',[QuartersController::class,'getDDOCode'])->name('ddo.getDDOCode');

// DDO login routes
Route::get('/ddo/login', [DdoUserLoginController::class, 'showLoginForm'])->name('ddo.login.form');
Route::post('/ddo/login', [DdoUserLoginController::class, 'login'])->name('ddo.login');
Route::post('/ddo/logout', [DdoUserLoginController::class, 'logout']);
Route::get('/ddo-dashboard', [DDOUserController::class, 'dashboard'])->name('ddo.dashboard')->middleware('auth:ddo_users');
Route::get('/ddo-quarters-normal', [DDOUserController::class, 'quartersNormal'])->name('ddo.quarters.normal')->middleware('auth:ddo_users');
//Route::post('/ddo-normalquarter-list', [DDOUserController::class, 'getNormalquarterList'])->name('normalquarter-list')->middleware('auth:ddo_users');
Route::post('/ddo-normalquarter-list', [DDOUserController::class, 'getNormalquarterList'])->name('ddo-normalquarter-list')->middleware('auth:ddo_users');
Route::get('/ddo-editquarter_a/{r}/{rv}', [DDOUserController::class, 'geteditquarter_a'])->name('ddo.editquarter.a.list')->middleware('auth:ddo_users');
//11-10-2024
Route::post('/ddo-editquarter_a', [DDOUserController::class, 'savedocument_a'])->name('ddo.editquarter.a.savedocument')->middleware('auth:ddo_users');
Route::post('/generateCertificate', [DDOUserController::class, 'generatecertificate_a'])->name('ddo.editquarter.a.generatecertificate')->middleware('auth:ddo_users');
Route::get('/ddo-editquarter_b/{r}/{rv}', [DDOUserController::class, 'geteditquarter_b'])->name('ddo.editquarter.b.list')->middleware('auth:ddo_users');
Route::post('/ddo-editquarter_a_submitdocument', [DDOUserController::class, 'submitdocument_a'])->name('ddo.editquarter.a.submitdocument')->middleware('auth:ddo_users');


Route::get('/ddo/reload-captcha', 'Auth\RegisterController@reloadCaptcha')->name('ddo.reload-captcha');
Route::get('/government_resolution', function () {
    
    return view('government_resolution'); // or any other logic
});
Route::get('/government_document', function () {
    
    return view('government_document'); // or any other logic
});

Route::get('/checkvacant', [CheckVacantController::class, 'index'])->name('vacant.quarter.form');
Route::get('quarterschange', [ 'as' => 'user.quarter.change', 'uses' => 'QuartersController@requestchange']);


Route::post('/gettalukabydistrict', [RegisterController::class, 'getTalukaByDistrict'])->name('getTalukaByDistrict');
Route::get('/setofficeemailpwd', [ 'as' => 'ddo.set_office_email_pwd', 'uses' => 'DdoUserLoginController@showOfficeEmailPwdForm']);

Route::post('/ddo/saveEmailPwd', [DdoUserLoginController::class, 'saveEmailPwd'])->name('ddo.saveEmailPwd');

Route::post('/update_file_status', [DDOUserController::class, 'updateFileStatus'])->name('updateFileStatus');; //12-12-2024
Route::post('/update_file_status_admin', [QuartersController::class, 'updateFileStatusAdmin'])->name('updateFileStatusAdmin');; //13-12-2024


Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');

    return 'Cache cleared successfully!';
}); // or your custom middleware


Route::get('/districts', [DashboardController::class, 'index'])->name('districts');
Route::post('get-quarter-type/', [DashboardController::class, 'getQuarterType'])->name('getQuarterType');
Route::post('get-area/', [DashboardController::class, 'getAreaWiseQurtCnt'])->name('getArea');
Route::post('get-quarter-total/', [DashboardController::class, 'getQuarterTotalList'])->name('getQuarterList');


//16-01-2025
Route::get('profile', [ 'as' => 'user.profile', 'uses' => 'ProfileController@index'])->middleware('verifiedphone', 'verified');