<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OpenSpout\Writer\XLSX\Writer;
use OpenSpout\Common\Entity\Row;
use Session;
use DB;
use App\Tquarterrequestb;
use App\Tquarterrequesta;
use App\Tquarterrequestc;

class ExcelExportController extends Controller
{
    public function export()
    {
        $fileName = 'sample_export.xlsx';
        $filePath = storage_path("app/public/{$fileName}");

        if (!file_exists(dirname($filePath))) {
            mkdir(dirname($filePath), 0777, true);
        }

        $writer = new Writer();
        $writer->openToFile($filePath);

        $writer->addRow(Row::fromValues(['ID', 'Name', 'Email']));
        $data = [
            [1, 'Alice', 'alice@example.com'],
            [2, 'Bob', 'bob@example.com'],
            [3, 'Charlie', 'charlie@example.com'],
        ];
        foreach ($data as $row) {
            $writer->addRow(Row::fromValues($row));
        }
        $writer->close();

        $response = response()->download($filePath, $fileName)
            ->deleteFileAfterSend(true);

        $response->headers->set(
            'Content-Type',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        );

        return $response;
    }
    public function exportWaitingListExcel(Request $request)
{
   $quartertype = $request->input('quartertype'); // array or string
$officecode  = (string) Session::get('officecode'); // ensure string

// Base query A
$first = Tquarterrequesta::select([
        DB::raw("'New' as requesttype"),
        DB::raw("'New' as tableof"),
        'requestid', 'wno', 'inward_no', 'inward_date', 'u.name', 'u.designation', 'quartertype', 'office',
        'rivision_id', 'date_of_retirement', 'contact_no', 'address', 'gpfnumber',
        'is_accepted', 'is_allotted', 'is_varified', 'email', 'u.id', 'r_wno',
        'office_email_id', 'office_remarks', 'withdraw_remarks', 'officecode'
    ])
    ->join('userschema.users as u', 'u.id', '=', 'master.t_quarter_request_a.uid');

// Base query B
$second = Tquarterrequestb::select([
        DB::raw("'Higher Category' as requesttype"),
        DB::raw("'Higher Category' as tableof"),
        'requestid', 'wno', 'inward_no', 'inward_date', 'u.name', 'u.designation', 'quartertype', 'office',
        'rivision_id', 'date_of_retirement', 'contact_no', 'address', 'gpfnumber',
        'is_accepted', 'is_allotted', 'is_varified', 'email', 'u.id', 'r_wno',
        'office_email_id', 'office_remarks', 'withdraw_remarks', 'officecode'
    ])
    ->join('userschema.users as u', 'u.id', '=', 'master.t_quarter_request_b.uid');

// Merge without filters
$union = $first->unionAll($second);

// Apply filters after union
$query = DB::table(DB::raw("({$union->toSql()}) as x"))
    ->mergeBindings($union->getQuery())
    ->select([
        'requesttype', 'tableof', 'requestid', 'wno', 'inward_no', 'inward_date', 'name', 'designation',
        'quartertype', 'office', 'rivision_id', 'date_of_retirement', 'contact_no', 'address', 'gpfnumber',
        'is_accepted', 'is_allotted', 'is_varified', 'email', 'id', 'r_wno', 'office_email_id',
        'office_remarks', 'withdraw_remarks', 'officecode'
    ])
    ->where('officecode', $officecode)
    ->where('is_accepted', 1)
    ->where('is_allotted', 0)
    ->where('is_varified', 1);

// quartertype filter;
if ($quartertype !== null && $quartertype !== '') {
    if (is_array($quartertype)) {
        $query->whereIn('quartertype', $quartertype);
    } else {
        $query->where('quartertype', $quartertype);
    }
}
// DEBUG: Print SQL with bindings replaced
/*$sql = vsprintf(
    str_replace('?', "'%s'", $query->toSql()),
    $query->getBindings()
);
dd($sql); // stops here so you can check the query
*/
$query->orderBy('wno');

$results = $query->get();
//dd($results);
    $fileName = 'waitinglist_export.xlsx';

    $writer = new \OpenSpout\Writer\XLSX\Writer();
    $writer->openToBrowser($fileName);

    // Add header row
    $writer->addRow(\OpenSpout\Common\Entity\Row::fromValues([
        'Request Type', 'Table Of', 'Request ID', 'RWNO', 'WNO', 'Inward No', 'Inward Date', 'Name', 'Designation',
        'Quarter Type', 'Office', 'Revision ID', 'Date of Retirement', 'Contact No', 'Address', 'GPF Number',
        'Is Accepted', 'Is Allotted', 'Is Verified', 'Email', 'User ID', 'Office Email ID', 'Office Remarks',
        'Withdraw Remarks', 'Office Code'
    ]));

    foreach ($results as $row) {
        $writer->addRow(\OpenSpout\Common\Entity\Row::fromValues([
            $row->requesttype,
            $row->tableof,
            $row->requestid,
            $row->r_wno,
            $row->wno,
            $row->inward_no,
            $row->inward_date,
            $row->name,
            $row->designation,
            $row->quartertype,
            $row->office,
            $row->rivision_id,
            $row->date_of_retirement,
            $row->contact_no,
            $row->address,
            $row->gpfnumber,
            $row->is_accepted,
            $row->is_allotted,
            $row->is_varified,
            $row->email,
            $row->id,
            $row->office_email_id,
            $row->office_remarks,
            $row->withdraw_remarks,
            $row->officecode
        ]));
    }

    $writer->close();
    exit; // Important: stop further output after streaming the file
}
}
