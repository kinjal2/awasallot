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
});

// Language switch
Route::get('locale/{locale}', function ($locale){
    Session::put('locale', $locale);
    return redirect()->back();
});

// Auth Routes
Auth::routes();
Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login')->middleware('guest');
Route::get('/grasapi', 'RegistrationController@apiLogin')->name('grasapi');
Auth::routes(['verify' => true]);

// Phone Verification Routes
Route::get('phone/verify', [PhoneVerificationController::class, 'show'])->name('phoneverification.notice');
Route::post('phone/verify', [PhoneVerificationController::class, 'verify'])->name('phoneverification.verify');

// Dashboard Routes
Route::middleware(['verifiedphone', 'verified'])->group(function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('userdashboard', ['uses' => 'DashboardController@userdashboard', 'as' => 'user.dashboard.userdashboard']);
    Route::get('profile', ['as' => 'user.profile', 'uses' => 'ProfileController@index']);
    Route::get('quartersuser', ['as' => 'user.Quarters', 'uses' => 'QuartersController@requestnewquarter']);
    Route::get('quarterschange', ['as' => 'user.quarter.change', 'uses' => 'QuartersController@requestchange']);
    Route::get('quartershistory', ['as' => 'user.quarter.history', 'uses' => 'QuartersController@index']);
});

// Admin Dashboard
Route::get('admindashboard', ['uses' => 'DashboardController@index', 'as' => 'admin.dashboard.admindashboard']);

// User Profile Routes
Route::post('profiledetails', 'ProfileController@updateprofiledetails');
Route::post('profiledetails_email', 'ProfileController@updateprofiledetails_email');

// Quarters Routes
Route::prefix('quarters')->group(function () {
    Route::get('listnormal', ['as' => 'quarter.list.normal', 'uses' => 'QuartersController@quarterlistnormal']);
    Route::get('listnew', ['as' => 'quarter.list.new', 'uses' => 'QuartersController@quarterNewRequest']);
    Route::get('listhistory', ['as' => 'quarter.list.history', 'uses' => 'QuartersController@index']);
    Route::post('saveapplication', ['as' => 'quarter.list.saveapplication', 'uses' => 'QuartersController@saveapplication']);
    Route::post('saveremarks', ['as' => 'quarter.list.saveremarks', 'uses' => 'QuartersController@saveremarks']);
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
    
    // DDO User Dashboard
    Route::middleware('auth:ddo_users')->group(function () {
        Route::get('dashboard', [DDOUserController::class, 'dashboard'])->name('ddo.dashboard');
        Route::get('quarters-normal', [DDOUserController::class, 'quartersNormal'])->name('ddo.quarters.normal');
        Route::post('quarters-normal-list', [DDOUserController::class, 'getNormalquarterList'])->name('ddo-normalquarter-list');
        Route::get('edit-quarter/{r}/{rv}', [DDOUserController::class, 'geteditquarter_a'])->name('ddo.editquarter.a.list');
    });
});

// User Routes
Route::prefix('user')->group(function () {
    Route::get('list', 'UserController@index')->name('user');
    Route::post('list', 'UserController@getList')->name('user.list');
    Route::post('resetpassword', 'UserController@resetpassword')->name('resetpassword');
    Route::post('resetname', 'UserController@resetname')->name('resetname');
    Route::get('quartershigher', [ 'as' => 'user.quarter.higher', 'uses' => 'QuartersController@requesthighercategory']);
    Route::get('userallotmentlist',['UserQuartersallotmentController@index','as'=>'userallotmentlist.index']);
    Route::post('/salarySlabDetails', [ProfileController::class, 'getSalarySlabDetails'])->name('salarySlabDetails');
    Route::get('ddo_details', [ 'as' => 'user.ddo_details', 'uses' => 'ProfileController@updateDDODetails']);
    Route::post('saveOfficeCode', ['uses' => 'QuartersController@saveOfficeCode']);
    Route::post('/getDDOCode',[QuartersController::class,'getDDOCode'])->name('ddo.getDDOCode');
    Route::get('quartersuser', [ 'as' => 'user.Quarters', 'uses' => 'QuartersController@requestnewquarter']);
    Route::post('savenewrequest', ['uses' => 'QuartersController@saveNewRequest']);
    Route::get('quartershigher', [ 'as' => 'user.quarter.higher', 'uses' => 'QuartersController@requesthighercategory']);
    Route::post('saveHigherCategoryReq', ['uses' => 'QuartersController@saveHigherCategoryReq']);
    Route::get('quarterschange', [ 'as' => 'user.quarter.change', 'uses' => 'QuartersController@requestchange']);

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

// Area Routes
Route::prefix('masterarea')->group(function () {
    Route::get('/', [AreaController::class, 'index'])->name('masterarea.index');
    Route::post('getList', 'AreaController@getList');
    Route::resource('masterarea', 'AreaController');
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
Route::get('/government_resolution', function () {
return view('government_resolution');
});
Route::get('/government_document', function () {
 return view('government_document'); 
});