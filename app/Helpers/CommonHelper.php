<?php
//Use Session;
use App\Quarter;
use App\Area;
use App\User;
use App\Filelist;
use App\MQtCategoryAreaMapping;
use App\Couchdb\Couchdb;
use App\PayScale;
use App\District;
use App\Taluka;
use App\DDOCode;
use App\Remarks;

function printLastQuery()
{
    ini_set('xdebug.var_display_max_depth', 5);
    ini_set('xdebug.var_display_max_children', 256);
    ini_set('xdebug.var_display_max_data', -1);
    $queries = \DB::getQueryLog();
    dd($queries);
}
if (!function_exists('getYesNo')) {
    function getYesNo()
    {
        // $yesno = [];
        // $yesno = ['Y' => "હા", 'N' => "ના"];
        // return $yesno;
        return [
            'Y' => __('common.yes'),
            'N' => __('common.no'),
        ];
    }
}
if (!function_exists('getMaratialstatus')) {
    function getMaratialstatus()
    {
        // $maratialstatus = [];
        // $maratialstatus = ['U' => "Unmarried", 'M' => "Married"];
        // return $maratialstatus;
        return [
            'U' => __('common.unmarried'),
            'M' => __('common.married'),
        ];
    }
}
if (!function_exists('getupdatestatus')) {
    function getupdatestatus()
    {
        $updatestatus = [];
        $updatestatus = ['1' => "Varified And Proper", '0' => "Varified But Have Issue"];
        return $updatestatus;
    }
}
//11-10-2024 function for pay slip and certificate option
if (!function_exists('getpayslip_certificate')) {
    function getpayslip_certificate()
    {
        $payslip_certificate = [];
        $payslip_certificate = ['10' => "Certificate", '2' => "Salary Pay Slip"];
        return $payslip_certificate;
    }
}
if (!function_exists('getBasicPay')) {
    function getBasicPay()
    {
        $basic_pay = Session::get('basic_pay');
        $q_officecode = Session::get('q_officecode');
        if ($basic_pay == '') {
            //$quarterselect= Quarter::get();
            $quarterselect = Quarter::where('officecode', $q_officecode)->get();
        } else {
            //$quarterselect= Quarter::where('bpay_from', '<=',$basic_pay)->where('bpay_to', '>=',$basic_pay)->get();
            $quarterselect = Quarter::where('bpay_from', '<=', $basic_pay)->where('bpay_to', '>=', $basic_pay)->where('officecode', $q_officecode)->get();
        }
        //dd($quarterselect);
        $quarterdetails = [];
        foreach ($quarterselect as $q) {
            $quarterdetails[$q->quartertype] = $q->quartertype_g;
        }
        return $quarterdetails;
    }
}
//9-11-2024 for showing salary slab dropdown
if (!function_exists('getSalarySlab')) {
    function getSalarySlab()
    {
        $basic_pay = Session::get('basic_pay');
        //dd($basic_pay);
        $q_officecode = Session::get('q_officecode');
        $quarterselect = Quarter::where('officecode', $q_officecode)
            // ->where('bpay_from', '<=', $basic_pay)
            // ->where('bpay_to', '>=', $basic_pay)
            ->get();
        $quarterdetails = [];
        foreach ($quarterselect as $q) {
            $quarterdetails[$q->bpay_from . "-" . $q->bpay_to] = "Category [" . $q->quartertype . "] " . $q->bpay_from . "-" . $q->bpay_to;
        }
        return $quarterdetails;
    }
}

if (!function_exists('getlowerquatercategory')) {
    function getlowerquatercategory()
    {
        $basic_pay = Session::get('basic_pay');
        $q_officecode = Session::get('q_officecode');
        $quarterselect = Quarter::where('bpay_from', '<=', $basic_pay)->where('officecode', $q_officecode)->get();
        $quarterdetails = [];
        foreach ($quarterselect as $q) {
            $quarterdetails[$q->quartertype] = $q->quartertype_g;
        }
        return $quarterdetails;
    }
}
function getAreaDetails($areaname = null)
{
    $q_officecode = Session::get('q_officecode');
    $Area = Area::where('officecode', $q_officecode)  // Apply the 'where' filter first
        ->pluck('areaname', 'areacode');  // Then use pluck() to get the specific columns
    return $Area->toArray();
}

if (!function_exists('qtBasicPayArr')) {
    function qtBasicPayArr()
    {
        $basic_pay = Session::get('basic_pay');
        $q_officecode = Session::get('q_officecode');
        $quarterselect = Quarter::where('bpay_from', '<=', $basic_pay)->where('officecode', $q_officecode)->get();
        //$quarterselect= Quarter::where('bpay_from', '<=',$basic_pay)->get();
        $quarterdetails = [];
        foreach ($quarterselect as $q) {
            $quarterdetails[$q->quartertype] = $q->bpay_from . "~" . $q->bpay_to;
        }
        return $quarterdetails;
    }
}



function getMenu($apply_permissions = true)
{

    $superadmin_menu = \Config::get('menu.superadmin');

    $admin_menu = \Config::get('menu.admin');
    $ddo_menu = \Config::get('menu.ddouser');
    $activeMenu = [];
    switch (getActiveRole()) {
        case 'admin':
            $activeMenu = $superadmin_menu;
            break;
        case 'user':
            $activeMenu = $admin_menu;
            break;
        case 'ddouser':
            $activeMenu = $ddo_menu;
            break;
        default:
            break;
    }


    if (getActiveRole() == 'admin') {

        foreach ($activeMenu as $menukey => $menuitem) {
            $currentMenu = $menuitem;
            if (empty($currentMenu['submenu']) === false) {
                foreach ($currentMenu['submenu'] as $subkey => $submenu) {
                }
                if (empty($currentMenu['submenu']) === true) {
                    unset($currentMenu);
                }
            }

            if (isset($currentMenu)) {
                $permitted_menu[$menukey] = $currentMenu;
            }
        }
        return $permitted_menu;
    }
    if (getActiveRole() == 'user') {

        foreach ($activeMenu as $menukey => $menuitem) {
            $currentMenu = $menuitem;
            if (empty($currentMenu['submenu']) === false) {
                foreach ($currentMenu['submenu'] as $subkey => $submenu) {
                }
                if (empty($currentMenu['submenu']) === true) {
                    unset($currentMenu);
                }
            }

            if (isset($currentMenu)) {
                $permitted_menu[$menukey] = $currentMenu;
            }
        }
        return $permitted_menu;
    }
    if (getActiveRole() == 'ddouser') {
        //
        // dd($activeMenu);
        foreach ($activeMenu as $menukey => $menuitem) {
            $currentMenu = $menuitem;
            if (empty($currentMenu['submenu']) === false) {
                foreach ($currentMenu['submenu'] as $subkey => $submenu) {
                }
                if (empty($currentMenu['submenu']) === true) {
                    unset($currentMenu);
                }
            }

            if (isset($currentMenu)) {
                $permitted_menu[$menukey] = $currentMenu;
            }
        }
        return $permitted_menu;
    }
    return $activeMenu;
}
/*function getActiveRole($active_role = null) {
    $superadmin_role_id ='true';
    $admin_role_id ='false';
    $active_role = \Auth::user()->is_admin;
    $sessionRole = session('role');
    // Check for role in session
    // Determine role name based on session or user properties
    if ($sessionRole === 'ddouser') {
        return 'ddouser'; // Return session role if it's ddo_user
    }
    switch ($active_role) {
       case $superadmin_role_id:
            $role_name = 'admin';
            break;
        default :
            $role_name = 'user';
            break;
    }

    return $role_name;
}*/
function getActiveRole($active_role = null)
{

    $superadmin_role_id = true;  // Assuming is_admin is true for superadmins
    $sessionRole = session('role');
    if ($sessionRole === 'ddouser') {
        return 'ddouser';  // If the session contains 'ddouser', return that role
    }

    // If session doesn't have 'ddouser', check the role from the database
    $active_role = \Auth::user()->is_admin;  // Assuming 'is_admin' is the indicator of the role in the database

    // Determine role name based on is_admin field value
    if ($active_role === $superadmin_role_id) {
        return 'admin';  // Superadmin role
    }

    return 'user';  // Default to 'user' if the role is not superadmin
}

function checkRequestIs($request_array)
{
    $is = '';
    if (empty($request_array) === false) {
        foreach ($request_array as $uri) {
            if (Request::is($uri)) {
                $is = 'active';
                break;
            }
        }
    }
    return $is;
}
function checkRequestIs_open($request_array)
{
    $is = '';
    if (empty($request_array) === false) {
        foreach ($request_array as $uri) {
            if (Request::is($uri)) {
                $is = 'menu-open';
                break;
            }
        }
    }
    return $is;
}
function generateImage($uid)
{
    // Retrieve the photo from the database
    $photo = Filelist::where('document_id', 0)->where('uid', $uid)->first();
    if (!$photo) {
        // Handle case when photo is not found
        return null;
    }

    // Initialize CouchDB connection
    $extended = new Couchdb(URL_COUCHDB, USERNAMECD, PASSWORDCD);
    $extended->InitConnection();

    try {
        // Fetch the document from CouchDB
        $response = $extended->getDocument(DATABASE, $photo->doc_id);
        $array = json_decode($response, true);

        // Check if '_attachments' key exists in the response
        if (isset($array['_attachments']) && is_array($array['_attachments'])) {
            $data = $array['_attachments'];

            // Iterate through each attachment and return the image data
            foreach ($data as $key => $value) {
                return file_get_contents(COUCHDB_DOWNLOADURL . "/" . DATABASE . "/" . $photo->doc_id . "/" . $key);
            }
        } else {
            // Handle case when there are no attachments
            return null; // or handle as needed
        }
    } catch (CouchNotFoundException $ex) {
        // Handle case when document is not found
        if ($ex->getCode() == 404) {
            return null;
        }
    }
}

if (!function_exists('generateRandomString')) {
    function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }
}




//added on 9-11-2024 a common function to show documents
function showDocument(Request $request)
{
    $doc_id = $request->doc_id;

    $extended = new Couchdb(URL_COUCHDB, USERNAMECD, PASSWORDCD);
    $extended->InitConnection();
    $status = $extended->isRunning();

    $getDocument = $extended->getDocument(DATABASE, $doc_id);
    //   dd($getDocument);
    $couchDbResponse = json_decode($getDocument, true);

    if (isset($couchDbResponse['_attachments'])) {
        $attachments = $couchDbResponse['_attachments'];
    } else {
        return "Document Not Found!";
    }

    foreach ($attachments as $key => $value) {
        $getFileContent = file_get_contents(COUCHDB_DOWNLOADURL . "/" . DATABASE . "/" . $doc_id . "/" . $key . "");
        $headers = ['Content-type' => $value['content_type']];

        if ($getFileContent) {
            // Generate a unique window name
            $windowName = 'document_window_' . uniqid();

            // JavaScript to open a new window with black background and show the document
            $js = "
            var win = window.open('', '$windowName', 'width=800,height=600');
            win.document.body.style.backgroundColor = 'black';
            win.document.write('<embed width=\"100%\" height=\"100%\" src=\"data:$value[content_type];base64," . base64_encode($getFileContent) . "\">');
        ";

            // Return the JavaScript to the client
            //return response()->javascript($js);
            // Return the base64 encoded content
            return response()->json([
                'document_url' => base64_encode($getFileContent),
                'contentType' => 'application/pdf',
                'status' => 'success',
            ]);
        } else {
            return "Error fetching the document";
        }
    }
}
if (!function_exists('getOfficeByCode')) {
    function getOfficeByCode($officeCode)
    {
        $query = "SELECT * FROM master.officesname WHERE officecode = ? ORDER BY officecode ASC";

        // Execute the query and fetch results
        $officeDetails = DB::select($query, [$officeCode]);

        return $officeDetails;
    }
}
//16-11-2024 for showing payscale and matrix level from m_payscale table
if (!function_exists('getPayScale')) {
    function getPayScale()
    {

        $payscaleselect = PayScale::select('*')->get();
        $payscaledetails = [];
        foreach ($payscaleselect as $p) {
            $payscaledetails[$p->level] = $p->level;
        }
        return $payscaledetails;
    }
}
if (!function_exists('getQuarterType')) {
    function getQuarterType()
    {
        $officecode = Session::get('officecode');
        //dd($officecode);
        if ($officecode != 28083) {
            // dd($officecode);
            $officecode = 28084;
        }

        $quarterTypeselect = QuarterType::where('officecode', $officecode)->get();

        //dd($quarterselect);
        $quartertypedetails = [];
        foreach ($quarterTypeselect as $q) {
            $quartertypedetails[$q->quartertype] = $q->quartertype_g;
        }
        return $quartertypedetails;
    }
}
if (!function_exists('getddoupdatestatus')) {
    function getddoupdatestatus()
    {
        $updatestatus = [];
        $updatestatus = ['1' => "Verified And Proper", '2' => "Have Issue"];
        return $updatestatus;
    }
}
if (!function_exists('getDistricts')) {
    function getDistricts()
    {


        $district = District::select('dcode', 'name_g', 'name_e')->orderBy('name_e')->get();


        // dd($district);
        $districtdetails = [];
        foreach ($district as $d) {
            $districtdetails[$d->dcode] = $d->name_e;
        }
        return $districtdetails;
    }
}

if (!function_exists('getTaluka')) {
    function getTaluka()
    {


        $taluka = Taluka::select('tcode', 'name_g', 'name_e', 'dcode')->get();

        //dd($taluka);
        $talukadetails = [];
        foreach ($taluka as $t) {
            $talukadetails[$t->tcode] = $t->name_e;
        }
        return $talukadetails;
    }
}
if (!function_exists('qCategoryAreaMapping')) {
    function qCategoryAreaMapping($qtype)
    {
        // dd($qtype);
        $results = MQtCategoryAreaMapping::with('area') // Eager load the 'area' relationship
            ->where('quartertype', $qtype) // Filter by 'quartertype'
            ->orderBy('id', 'asc') // Order by 'id' in ascending order
            ->get(); // Execute the query and get the results
        $araedetails = [];
        // dd($results);
        foreach ($results as $q) {

            $araedetails[$q->areacode] = $q->area->areaname;
        }
        $araedetails['-1'] = 'All of Any';
        //dd($araedetails); 
        return $araedetails;
    }
}

if (!function_exists('getDistrictsWithOfficeCodes')) {
    function getDistrictsWithOfficeCodes()
    {
        $districts = [
            28084 => 'Ahmedabad',
            28083 => 'Gandhinagar',
        ];
        return $districts;
    }
}
if (!function_exists('getDDO_OfficeByCode')) {
    function getDDO_OfficeByCode($cardex_no, $ddo_code)
    {
        //dd($cardex_no,$ddo_code);
        $officeName = DDOCode::select('ddo_office')
            ->where('ddo_code', $ddo_code)
            ->where('cardex_no', $cardex_no)
            ->first();

        return $officeName['ddo_office'];
    }
}
if (!function_exists('getRemarks')) {
    function getRemarks()
    {


        $remarks = Remarks::select('remark_id', 'description')->get();

        //dd($taluka);
        $remarksdetails = [];
        foreach ($remarks as $r) {
            $remarksdetails[$r->remark_id] = $r->description;
        }
        // Add "Other" option at the beginning or at the end
        $remarksdetails['other'] = 'Other';  // Add 'Other' option with value 'other'
        return $remarksdetails;
    }
}
function uploadDocuments($docId, $file, $uid = null)
{
    // echo "<pre>";
    //  print_r($file['f']);
    //  die;
    // If $uid is null, fetch it from the session
    if ($uid === null) {
        $uid = Session::get('Uid');
    }
    //dd($uid);
    $parts = explode('_', $docId);
    //print_r($parts);
    //dd($parts);
    //die;
    //echo $docId;
    $arrayLength = count($parts);
    if ($arrayLength == 3) {
        $request_id = $parts[0];
        $document_type = $parts[1];
        $perfoma = 'P';
        $request_rev = $parts[0];
    } else {

        $request_id = $parts[1];
        $document_type = $parts[2];
        $perfoma = $parts[3];
        $request_rev = $parts[4];
    }


    $extended = new Couchdb(URL_COUCHDB, USERNAMECD, PASSWORDCD);
    $extended->InitConnection();
    $status = $extended->isRunning();
    // dd($status);
    $getDocument = $extended->getDocument(DATABASE, $docId);

    $checkDoc = json_decode($getDocument, true);

    $dummy_data = array($request_id => $perfoma);
    if ($checkDoc && isset($checkDoc['_rev'])) {
        //dd("hello");
        $out = $extended->updateDocument($dummy_data, DATABASE, $docId, $checkDoc['_rev']);
        // dd($out);
    } else {
        // dd("else");
        $out = $extended->createDocument($dummy_data, DATABASE, $docId);
    }
    //dd($out);
    $array = json_decode($out, true);
    //dd($getDocument,$checkDoc,$array); dd($array);
    //$rev = $array['rev'];
    $rev = $array['rev'] ?? null;
    //dd($rev);
    //  dd($file);
    $path = array();
    // $file=$file['image'];
    if ($file != null) {
        // $file = $request->file('image');
        // dd($file);
        $MimeType = $file->getClientMimeType();
        $extension = $file->extension() ?: $file->getClientOriginalExtension() ?: 'pdf';

        // Define $path as an array and assign values to its elements
        $path = [
            'id' => $docId,
            'tmp_name' => $file->getRealPath(),
            'extension' => $extension,
            'name' => $docId . '.' . $extension
        ];
        // dd($path);
        $fileName = $file->getClientOriginalName();
    }
    //dd($path);
    try {
        $createAttachment = $extended->createAttachmentDocument(DATABASE, $docId, $rev, $path);
        $arrayAttachment = json_decode($createAttachment, true);
    } catch (EXception $e) {
        dd($e->getMessage());
    }
    //$rev = isset($arrayAttachment['rev']) ? $arrayAttachment['rev'] : null;
    $rev = isset($arrayAttachment['rev']) ? $arrayAttachment['rev'] : 0;
    // echo "Doc type" . $document_type."<br>";
    // echo "Request Id" . $request_id."<br>";
    // echo "Perform" . $perfoma."<br>";
    // echo "Request Rev" . $request_rev."<br>";
    // echo "Doc Id" . $docId."<br>";
    // echo "Mime type" . $MimeType."<br>";
    // echo "Filename" . $fileName."<br>";
    // echo "Rev" . $rev."<br>";
    // die;
    try {
        // $File_list = Filelist::updateOrCreate(
        //     [
        //         'uid' => $uid,
        //        // 'file_name' => $fileName,
        //      //   'rev_id' => $rev,
        //         'doc_id' => $docId,
        //     ],
        //     [
        //         'mimetype' => $MimeType,
        //         'doc_id' => $docId,
        //         'performa' => $perfoma,
        //         'document_id' => $document_type,
        //         'rivision_id' => $request_rev,
        //         'request_id' => $request_id,
        //         'is_file_ddo_verified'=>0, // added on 19-03-2025
        //         'is_file_admin_verified'=>0, // added on 19-03-2025
        //         'file_name' => $fileName, // added on 19-03-2025
        //         'rev_id' => $rev, // added on 19-03-2025
        //     ]
        // );


        $attributes = [
            'uid'    => $uid,
            'doc_id' => $docId,
        ];

        // Fetch existing record (if any)
        $existing = Filelist::where($attributes)->first();

        // Prepare common data
        $data = [
            'file_name'              => $fileName,
            'rev_id'                 => $rev,
            'mimetype'               => $MimeType,
            'performa'               => $perfoma,
            'document_id'            => $document_type,
            'rivision_id'            => $request_rev,
            'request_id'             => $request_id,
            'is_file_ddo_verified'   => 0,
            'is_file_admin_verified' => 0,
        ];
      //  dd($existing);
        // If existing is found and verified by DDO, increment rev and create new
        if ($existing && ($existing->is_file_ddo_verified == 2 || $existing->is_file_admin_verified == 2 )) {
            $data['rivision_id'] = (int) $request_rev + 1;
            Filelist::create(array_merge($attributes, $data));
        } else {
            // Otherwise update or create based on uid + doc_id
            Filelist::updateOrCreate($attributes, $data);
        }
    } catch (EXception $e) {
        dd($e->getMessage());
    }


    //echo "Doc recorded. id = ".$response->id." and revision = ".$response->rev."<br>\n";
    //dd("Doc recorded. id = ".$response->id." and revision = ".$response->rev."<br>\n");


}
if (!function_exists('getDistrictByCode')) {
    function getDistrictByCode($dcode, $lang = null)
    {

        $locale = App::getLocale(); // Get current app language, e.g., 'en' or 'gu'
        //dd($locale);
        $district = District::select('dcode', 'name_g', 'name_e')->where('dcode', $dcode)->first();

        if (!$district) {
            return ''; // or return 'Unknown'
        }
        // dd($district);
        if ($lang) {
            if ($lang == 'gn') {
                return $district->name_g;
            } else {
                return $district->name_e;
            }
        } else {
            return $locale === 'gn' ? $district->name_g : $district->name_e;
        }
    }
}
if (!function_exists('getDistrictByCode')) {
    function getDistrictByCode($dcode, $lang = null)
    {

        $locale = App::getLocale(); // Get current app language, e.g., 'en' or 'gu'
        //dd($locale);
        $district = District::select('dcode', 'name_g', 'name_e')->where('dcode', $dcode)->first();

        if (!$district) {
            return ''; // or return 'Unknown'
        }
        // dd($district);
        if ($lang) {
            if ($lang == 'gn') {
                return $district->name_g;
            } else {
                return $district->name_e;
            }
        } else {
            return $locale === 'gn' ? $district->name_g : $district->name_e;
        }
    }
}

function getAreaDetailsByCode($areacode)
{
    $q_officecode = Session::get('q_officecode');
   
    if($areacode == -1 )
    {
        return  "All of Any";
    }
    else
    {
    $Area = Area::where('officecode', $q_officecode)  // Apply the 'where' filter first
        ->where('areacode',$areacode)
        ->pluck('areaname')->first();  // Then use pluck() to get the specific columns
    return $Area;
    }
}