<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestMail;
use App\Http\Controllers\PhoneVerificationController;
use App\Http\Controllers\FileDownloadController;
use App\Http\Controllers\DDOController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\QuarterTypeController;
use App\Http\Controllers\DdoUserLoginController;
use App\Http\Controllers\DDOUserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CheckVacantController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\QuartersController;
use App\Http\Controllers\CaptchaController;
use App\Http\controllers\UserQuartersallotmentController;
use App\QuarterType;

/*
|---------------------------------------------------------------------------
| Web Routes
|---------------------------------------------------------------------------
|
| Here is where you can register web routes for your application.
| These routes are loaded by the RouteServiceProvider within a group
| which contains the "web" middleware group. Now create something great!
|
*/

// Route for test email
Route::get('/send-test-email', function () {
    Mail::to('mohitupadhyay90@gmail.com')->send(new TestMail());
    return 'Test email sent 11dfd!';
});

// Home route
Route::get('/', function () {
    return view('welcome');
})->middleware('prevent_clickjacking');

// Language switch
Route::get('locale/{locale}', function ($locale){
    Session::put('locale', $locale);
    return redirect()->back();
});

// Auth Routes
Auth::routes();
Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login')->middleware('guest');

//Route::get('otp-login', [LoginController::class, 'showOtpLoginForm'])->name('otp.login.form');
Route::post('/otp-login', [LoginController::class, 'sendOtp'])->name('otp.login');
Route::get('/otp-verify', [LoginController::class, 'otpVerification'])->name('otp.verification.form');
//Route::post('otp-verify', [LoginController::class, 'verifyOtp'])->name('otp.verify');



Route::get('/grasapi', 'RegistrationController@apiLogin')->name('grasapi');
Auth::routes(['verify' => true]);

// Phone Verification Routes
Route::get('/phone/verify', [PhoneVerificationController::class, 'show'])->name('phoneverification.notice');
Route::post('/phone/verify', [PhoneVerificationController::class, 'verify'])->name('phoneverification.verify');
Route::get('/home', 'HomeController@index')->name('home');
Route::post('/home', 'HomeController@index')->name('home');
// Dashboard Routes user 
 Route::middleware(['verifiedphone', 'verified','role:user','check.host','prevent_clickjacking','check.session','session.timeout'])->group(function () {   
    Route::get('userdashboard', ['uses' => 'DashboardController@userdashboard', 'as' => 'user.dashboard.userdashboard']);
    Route::get('profile', ['as' => 'user.profile', 'uses' => 'ProfileController@index']);
    Route::get('quartersuser', ['as' => 'user.Quarters', 'uses' => 'QuartersController@requestnewquarter']);
    Route::get('quarterschange', ['as' => 'user.quarter.change', 'uses' => 'QuartersController@requestchange']);
    Route::get('quartershistory', ['as' => 'user.quarter.history', 'uses' => 'QuartersController@index']);
    Route::get('ddo_details', [ 'as' => 'user.ddo_details', 'uses' => 'ProfileController@updateDDODetails']);
    Route::get('updateoldprofile', [ 'as' => 'user.update_old_profile_details', 'uses' => 'ProfileController@updateOldProfileDetails']);
    Route::post('saveoldprofile', [ 'as' => 'user.saveoldprofiledetails', 'uses' => 'ProfileController@saveOldProfileDetails']);
    Route::post('gettalukasbydistrict', [ProfileController::class, 'getTalukasByDistrict'])->name('getTalukasByDistrict');

    
    Route::post('savenewrequest', ['uses' => 'QuartersController@saveNewRequest']);
    Route::get('quartershigher', [ 'as' => 'user.quarter.higher', 'uses' => 'QuartersController@requesthighercategory']);
    Route::post('saveHigherCategoryReq', ['uses' => 'QuartersController@saveHigherCategoryReq']);
    Route::get('quarterschange', [ 'as' => 'user.quarter.change', 'uses' => 'QuartersController@requestchange']);

    Route::get('quarters', [ 'as' => 'quarters', 'uses' => 'QuartersController@index']);
    
   
   
    
    Route::get('uploaddocument/:any', ['uses' => 'QuartersController@uploaddocument']);
    Route::post('saveuploaddocument', ['uses' => 'QuartersController@saveuploaddocument']);
    Route::post('/get-document-url', [ 'as' => 'quarter.list.showDocument', 'uses' => 'QuartersController@showDocument']);
    Route::post('deletedoc', ['uses' => 'QuartersController@deletedoc']);
    Route::post('savefinalannexure',['as'=>'quarter.final.annexure','uses'=>'QuartersController@savefinalAnnexure']);
    Route::get('userallotmentlist', [UserQuartersallotmentController::class, 'index'])->name('userallotmentlist.index');
    Route::post('getListallot', [UserQuartersallotmentController::class, 'getList'])->name('getListallot');

    Route::post('request-history', ['uses' => 'QuartersController@requestHistory']);
    Route::post('saveOfficeCode', ['uses' => 'QuartersController@saveOfficeCode']);

        
});

// Admin Dashboard


    Route::middleware(['role:admin','check.host','session.timeout'])->group(function () {
    Route::get('admindashboard', ['uses' => 'DashboardController@index', 'as' => 'admin.dashboard.admindashboard']);
    Route::get('user', [ 'as' => 'user', 'uses' => 'UserController@index']);
  //  Route::get('admin-users', [AdminController::class, 'users'])->name('admin.users');
    Route::post('get-quarter-type/', [DashboardController::class, 'getQuarterType'])->name('getQuarterType');
    Route::post('get-area/', [DashboardController::class, 'getAreaWiseQurtCnt'])->name('getArea');
    Route::post('get-quarter-total/', [DashboardController::class, 'getQuarterTotalList'])->name('getQuarterList');
    Route::post('/designationselection', 'UserController@designationselection')->name('designationselection');
    Route::get('/checkuser', 'UserController@checkuser')->name('checkuser');
    Route::get('quarter-police-document', ['as' => 'quarter.police.document', 'uses' => 'PolicestaffController@index']);
    Route::post('normalquarter-list', ['as' => 'normalquarter-list', 'uses' => 'QuartersController@getNormalquarterList']);
    Route::get('editquarter_a/{r}/{rv}', ['as' => 'editquarter_a', 'uses' => 'QuartersController@editquarter_a']);
   // Route::get('editquarter_a/{r}/{rv}', ['as' => 'editquarter_a', 'uses' => 'QuartersController@editquarter_a']);
    Route::get('editquarter_b/{r}/{rv}', ['as' => 'editquarter_b', 'uses' => 'QuartersController@editquarter_b']);
    Route::post('saveapplication', [ 'as' => 'quarter.list.saveapplication', 'uses' => 'QuartersController@saveapplication']);
    Route::post('saveapplication_b', [ 'as' => 'quarter.list.saveapplication_b', 'uses' => 'QuartersController@saveapplication_b']);

    Route::post('getremarks', ['as' => 'quarter.list.getremarks', 'uses' => 'QuartersController@getremarks']);
    Route::post('saveremarks', ['as' => 'quarter.list.saveremarks', 'uses' => 'QuartersController@saveremarks']);
    Route::post('listremarks', ['as' => 'quarter.list.listremarks', 'uses' => 'QuartersController@listremarks']);
    Route::post('addremarks', ['as' => 'quarter.list.addnewremark', 'uses' => 'QuartersController@addnewremarks']);
  //  Route::get('listnormal', ['as' => 'quarter.list.normal', 'uses' => 'QuartersController@quarterlistnormal']);
  Route::get('quarterlistnormal', [ 'as' => 'quarter.list.normal', 'uses' => 'QuartersController@quarterlistnormal']);
  Route::post('waiting-list', [ 'as' => 'waitinglist.data','uses' => 'ReportsController@getWaitingList']);
  Route::post('getdocumentdata', [ 'as' => 'getdocumentdata','uses' => 'ReportsController@getdocumentdata']);
 Route::get('quarterlistpriority',['QuartersPriorityController@index','as'=>'quarterlistpriority.index']);
	Route::resource('quarterlistpriority', 'QuartersPriorityController');
	 Route::get('allotmentlist', ['as' => 'allotment.list', 'uses' => 'ReportsController@allotmentlist']);
    Route::get('vacantlist', ['as' => 'vacant.list', 'uses' => 'ReportsController@vacantlist']);
    Route::get('quarteroccupancy', ['as' => 'quarter.occupancy', 'uses' => 'ReportsController@quarteroccupancy']);
	
	Route::post('allotment-list', ['as' => 'allotment-list', 'uses' => 'ReportsController@getAllotmentList']);
	Route::post('vacant-list', ['as' => 'vacant-list', 'uses' => 'ReportsController@getVacantList']);

	Route::post('vacant_quarter', ['as' => 'vacant_quarter', 'uses' => 'ReportsController@vacant_quarter']);


	Route::get('quarter-occupancy', ['as' => 'quarter.occupancy', 'uses' => 'ReportsController@quarteroccupancy']);
	Route::post('quarteroccupancylist', ['as' => 'quarter.occupancy.list', 'uses' => 'ReportsController@getquarteroccupancy']);
	Route::post('policestaff-data', [ 'as' => 'policestaff.data','uses' => 'PolicestaffController@getpolicedocumentList']);
	Route::get('editquarter_police_a/{r}/{rv}/{performa}', ['as' => 'editquarter_police_a', 'uses' => 'PolicestaffController@editquarter_a']);
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

    Route::get('admin-quarters-rejected', [QuartersController::class, 'admin_quartersRejected'])->name('request.rejected');
    Route::post('admin-quarters-rejected-list', [QuartersController::class, 'admin_getRejectedQuarterList'])->name('request.rejectedquarter-list');

    // Other admin-specific routes
});






// User Profile Routes
Route::post('profiledetails', 'ProfileController@updateprofiledetails');
Route::post('profiledetails_email', 'ProfileController@updateprofiledetails_email');

// Quarters Routes
Route::prefix('quarters')->group(function () {
    // Route::get('listnormal', ['as' => 'quarter.list.normal', 'uses' => 'QuartersController@quarterlistnormal']);
    Route::get('listnew', ['as' => 'quarter.list.new', 'uses' => 'QuartersController@quarterNewRequest']);
    Route::get('listhistory', ['as' => 'quarter.list.history', 'uses' => 'QuartersController@index']);
 //   Route::post('saveapplication', ['as' => 'quarter.list.saveapplication', 'uses' => 'QuartersController@saveapplication']);
    //Route::post('saveremarks', ['as' => 'quarter.list.saveremarks', 'uses' => 'QuartersController@saveremarks']);
    Route::post('savehighercategory', ['as' => 'quarter.list.savehighercategory', 'uses' => 'QuartersController@saveHigherCategoryReq']);


    
});

// Reports Routes
Route::prefix('reports')->group(function () {
    Route::get('waitinglist', ['as' => 'waiting.list', 'uses' => 'ReportsController@waitinglist']);
    Route::get('allotmentlist', ['as' => 'allotment.list', 'uses' => 'ReportsController@allotmentlist']);
    Route::get('vacantlist', ['as' => 'vacant.list', 'uses' => 'ReportsController@vacantlist']);
    Route::get('quarteroccupancy', ['as' => 'quarter.occupancy', 'uses' => 'ReportsController@quarteroccupancy']);
});

// Quarters PDF generation
Route::get('/generate-pdf/{request_id}/{revision_id}/{performa}', 'QuartersController@generate_pdf')->name('generate.pdf');

// DDO Routes
Route::prefix('ddo')->group(function () {
    Route::get('list', [DDOController::class, 'index'])->name('ddo.list');
    Route::post('list', [DDOController::class, 'show_ddolist'])->name('ddo.showlist');
    Route::get('add', [DDOController::class, 'addNewDDO'])->name('ddo.addNewDDO');
    Route::post('add', [DDOController::class, 'addNewDDOStore'])->name('ddo.store');
    
    // DDO Login Routes
    Route::get('login', [DdoUserLoginController::class, 'showLoginForm'])->name('ddo.login.form');
    Route::post('login', [DdoUserLoginController::class, 'login'])->name('ddo.login');
    Route::post('logout', [DdoUserLoginController::class, 'logout']);
    
    Route::get('/setofficeemailpwd', [ 'as' => 'ddo.set_office_email_pwd', 'uses' => 'DdoUserLoginController@showOfficeEmailPwdForm']);

    Route::post('/ddo/saveEmailPwd', [DdoUserLoginController::class, 'saveEmailPwd'])->name('ddo.saveEmailPwd');

    Route::post('/update_file_status', [DDOUserController::class, 'updateFileStatus'])->name('updateFileStatus');; //12-12-2024
    Route::post('/update_file_status_admin', [QuartersController::class, 'updateFileStatusAdmin'])->name('updateFileStatusAdmin');; //13-12-2024

    

    // DDO User Dashboard
    Route::middleware(['auth:ddo_users','session.timeout'])->group(function () {
        Route::get('dashboard', [DDOUserController::class, 'dashboard'])->name('ddo.dashboard');
        Route::get('quarters-normal', [DDOUserController::class, 'quartersNormal'])->name('ddo.quarters.normal');
        Route::post('quarters-normal-list', [DDOUserController::class, 'getNormalquarterList'])->name('ddo-normalquarter-list');
        Route::get('edit-quarter/{r}/{rv}', [DDOUserController::class, 'geteditquarter_a'])->name('ddo.editquarter.a.list');
        Route::post('/ddo-editquarter_a', [DDOUserController::class, 'savedocument_a'])->name('ddo.editquarter.a.savedocument')->middleware('auth:ddo_users');
        Route::post('/generateCertificate', [DDOUserController::class, 'generatecertificate_a'])->name('ddo.editquarter.a.generatecertificate')->middleware('auth:ddo_users');
        Route::get('/ddo-editquarter_b/{r}/{rv}', [DDOUserController::class, 'geteditquarter_b'])->name('ddo.editquarter.b.list')->middleware('auth:ddo_users');
        Route::post('/ddo-editquarter_a_submitdocument', [DDOUserController::class, 'submitdocument_a'])->name('ddo.editquarter.a.submitdocument')->middleware('auth:ddo_users');
        Route::post('/ddo-editquarter_b_submitdocument', [DDOUserController::class, 'submitdocument_b'])->name('ddo.editquarter.b.submitdocument')->middleware('auth:ddo_users');
        Route::get('/ddo-viewprofile/{uid}', [DDOUserController::class, 'getuserprofile'])->name('ddo.viewuserprofile')->middleware('auth:ddo_users');
Route::post('/user_quarter_application',[DDOUserController::class,'getUserQuarterApplication'])->name('ddo.getUserQuarterApplication')->middleware('auth:ddo_users');
Route::get('quarters-rejected', [DDOUserController::class, 'quartersRejected'])->name('ddo.request.rejected');
Route::post('quarters-rejected-list', [DDOUserController::class, 'getRejectedQuarterList'])->name('ddo-rejectedquarter-list');
Route::post('getDDOremarks', ['as' => 'quarter.list.getDDOremarks', 'uses' => 'DDOUserController@getDDOremarks']);





      
        
    });
});

// User Routes
Route::prefix('user')->group(function () {
    Route::get('list', 'UserController@index')->name('user');
    Route::post('list', 'UserController@getList')->name('user.list');
    Route::post('resetpassword', 'UserController@resetpassword')->name('resetpassword');
    Route::post('resetname', 'UserController@resetname')->name('resetname');
    Route::get('quartershigher', [ 'as' => 'user.quarter.higher', 'uses' => 'QuartersController@requesthighercategory']);
  
    Route::post('/salarySlabDetails', [ProfileController::class, 'getSalarySlabDetails'])->name('salarySlabDetails');
    
    
    Route::post('/getDDOCode',[QuartersController::class,'getDDOCode'])->name('ddo.getDDOCode');
    
    

});

// Quarter Type Routes
Route::prefix('masterquartertype')->group(function () {
    Route::get('/', [QuarterTypeController::class, 'index'])->name('masterquartertype.index');
    Route::post('getList1', 'QuarterTypeController@getList');
    Route::get('edit/{officecode}/{quartertype}/edit', [QuarterTypeController::class, 'editQuarterType'])->name('masterquartertype.editQuarterType');
    Route::post('edit', [QuarterTypeController::class, 'store'])->name('masterquartertype.store');
    Route::get('add', [QuarterTypeController::class, 'addQuarterType'])->name('masterquartertype.addQuarterType');
    Route::post('add', [QuarterTypeController::class, 'storenew'])->name('masterquartertype.storenew');
    Route::resource('masterquartertype', 'QuarterTypeController');
    
});


// Cache clear route
Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');

    return 'Cache cleared successfully!';
});
Route::get('/checkvacant', [CheckVacantController::class, 'index'])->name('vacant.quarter.form');
Route::get('/checkuser', 'UserController@checkuser')->name('checkuser');
Route::get('ddo_details', [ 'as' => 'user.ddo_details', 'uses' => 'ProfileController@updateDDODetails']);

//17-01-2025
Route::get('emp-list',[DDOUserController::class,'getEmpList'])->name('ddo.emp-list')->middleware('auth:ddo_users');
Route::post('show-emp-list',[DDOUserController::class,'showEmpList'])->name('ddo-show-emp-list')->middleware('auth:ddo_users');

//23-1-2025
Route::get('/ddo-viewprofile/{uid}', [DDOUserController::class, 'getuserprofile'])->name('ddo.viewuserprofile')->middleware('auth:ddo_users');
Route::post('/user_quarter_application',[DDOUserController::class,'getUserQuarterApplication'])->name('ddo.getUserQuarterApplication')->middleware('auth:ddo_users');

//24-1-2025
Route::get('change-quarter-request', [ 'as' => 'user.quarter.change', 'uses' => 'QuartersController@requestchange']);
Route::get('/government_resolution', function () {
return view('government_resolution');
});
Route::get('/government_document', function () {
 return view('government_document'); 
});

Route::post('/gettalukabydistrict', [RegisterController::class, 'getTalukaByDistrict'])->name('getTalukaByDistrict');
Route::get('reload-captcha', 'Auth\RegisterController@reloadCaptcha')->name('reload-captcha');
Route::get('/ddo/reload-captcha', 'Auth\RegisterController@reloadCaptcha')->name('ddo.reload-captcha');
Route::get('/phone/reload-captcha', 'CaptchaController@reloadCaptcha')->name('phone.reload-captcha');



Route::get('/logout', 'Auth\LoginController@logout');

Route::get('/ddo-quarters-normal', [DDOUserController::class, 'quartersNormal'])->name('ddo.quarters.normal')->middleware('auth:ddo_users');
Route::post('/designationselection', 'UserController@designationselection')->name('designationselection');
Route::post('get-quarter-type/', [DashboardController::class, 'getQuarterType'])->name('getQuarterType');
Route::post('get-area/', [DashboardController::class, 'getAreaWiseQurtCnt'])->name('getArea');
Route::post('get-quarter-total/', [DashboardController::class, 'getQuarterTotalList'])->name('getQuarterList');
Route::get('quarter-police-document', ['as' => 'quarter.police.document', 'uses' => 'PolicestaffController@index']);
Route::post('normalquarter-list', ['as' => 'normalquarter-list', 'uses' => 'QuartersController@getNormalquarterList']);
Route::get('/download_file/{filename}', [FileDownloadController::class, 'showDoc'])->name('download_file');


Route::get('/custom-403', function () {
    return view('errors.403');
})->name('custom.403.page');


Route::get('/test',function(){
    echo "test";
})->name('test');


 