<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Premise;
use App\Application;
use App\DrawResult;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use Session;
use App\DrawBatch;
use App\Exports\DrawResultExport;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Str;
use App\DrawLog;
use Mpdf\Mpdf;


class DrawController extends Controller
{


    public function index()
    {

        $officecode = Session::get('officecode');
        $quartertype = Session::get('quartertype', 'J');
        $batchId = Session::get('batch_id');

        //$selectedQuarter = session('quartertype');
        $selectedQuarter = 'J';

        // Get latest batch for selected quarter
        /*$batch = DrawBatch::where('quarter_type', $selectedQuarter)
                
                ->latest()
                ->first();*/
        $batch = DrawBatch::where('quarter_type', 'J')
            ->latest()
            ->first();

        $batchId = $batch?->id;
        $status  = $batch?->draw_status;

        // Load draw results only for this batch
        $results = $batchId
            ? DrawResult::where('batch_id', $batchId)->orderBy('id')->get()
            : collect();

        // Quarter dropdown
        $quartertype = DB::table('master.m_quarter_type')
            ->where('officecode', $officecode)
            ->orderBy('priority')
            ->pluck('quartertype', 'quartertype')
            ->toArray();
        //  dd($status);
        return view('draw.upload', [
            'page_title'      => 'Draw Upload',
            'results'         => $results,
            'quartertype'     => $quartertype,
            'status'          => $status,
            'selectedQuarter' => $selectedQuarter,
            'batch'           => $batch
        ]);
    }




    public function uploadExcel(Request $request)
    {
        $today = Carbon::today()->format('Y-m-d');
        $maxDate = Carbon::today()->addMonths(3)->format('Y-m-d');

        $request->validate([
            // 'file'=>'required|mimes:xlsx,xls',
            'draw_date' => "required|date|after_or_equal:$today|before_or_equal:$maxDate",
            'quartertype' => 'required',
            'file' => 'required|file|mimes:xls,xlsx|max:100',
            'batch_title' => 'required|string|min:5',
            'confirmCheck' => 'accepted',

        ], [
            'confirmCheck.accepted' => 'Please confirm that the data has been verified before uploading.'
        ]);

        $file = $request->file('file');

        $spreadsheet = IOFactory::load($file->getRealPath());

        $sheetNames = $spreadsheet->getSheetNames();
        //dd($sheetNames);
        if (count($sheetNames) != 2) {
            return back()->with('error', 'Excel must contain exactly 2 sheets');
        }

        // $sheetNames = array_map('strtolower', $sheetNames);
        // //dd($sheetNames);
        // if ($sheetNames[0] != 'beneficiary' || $sheetNames[1] != 'premise') {
        //     return back()->with('error', 'Sheet names must be beneficiary and premise');
        // }
        $sheetNames = array_map(function ($name) {
            return strtolower(trim($name));
        }, $sheetNames);

        // dd($sheetNames);

        if (!in_array('beneficiary', $sheetNames) || !in_array('premise', $sheetNames)) {
            return back()->with('error', 'Sheet names must be beneficiary and premise');
        }


        try {

            DB::beginTransaction();

            $quartertype = $request->quartertype;

            /*  Application::where('quarter_type', $quartertype)->delete();
            Premise::where('quarter_type', $quartertype)->delete();*/


            /*   $batch =DrawBatch::updateOrCreate(
    ['quarter_type'=>$quartertype],
    [
        'batch_title'=>$request->batch_title,
        'draw_status'=>'uploaded',
        'demo_run_count'=>0
    ]
);*/
            //dd($request->draw_date);
            $quartertype = $request->quartertype;
            $date = date('dmY', strtotime($request->draw_date));
            $random = strtoupper(Str::random(5));

            $batch_no = $quartertype . '/' . $date . '/' . $random;
            $batch = DrawBatch::create([
                'quarter_type' => $quartertype,
                'batch_title' => $request->batch_title,
                'draw_status' => 'uploaded',
                'demo_run_count' => 0,
                'batch_no' =>  $batch_no,
                'draw_date' => $request->draw_date
            ]);
            $batchId = $batch->id;

            Excel::import(new \App\Imports\DrawMultiSheetImport($batchId, $request->quartertype), $request->file('file'));
            /* Session::put('batch_id', $batchId);
            Session::put('quartertype', $request->quartertype);*/

            DB::commit();

            /*  Session::put('quartertype', $quartertype);*/

            // return redirect()->route('draw.index')
            //     ->with('success', 'Excel Uploaded Successfully. Click on Verify Data');
            DrawLog::create([
                'uid'       => Session::get('officecode'),
                'batch_id'  => $batch->id,
                'operation' => 'UPLOAD',
                'remarks'   => 'Applicant and Premise list uploaded',
                'ip'        => request()->ip(),
            ]);
            return redirect()->route('draw.history')
                ->with('success', 'Excel Uploaded Successfully. Click on Verify Data');
        } catch (\Throwable $e) {

            DB::rollBack();
            DrawLog::create([
                'uid'       => Session::get('officecode'),
                'batch_id'  => $batch->id,
                'operation' => 'UPLOAD ISSUE',
                'remarks'   => 'Applicant and Premise list uploaded has an issue' . $e->getMessage(),
                'ip'        => request()->ip(),
            ]);
            dd($e->getMessage(), $e->getLine());
        }
    }

    public function verifyPreview(Request $request)
    {
        $quartertype = $request->quartertype;
        $batch_id = $request->batch_id;
        $batch = DrawBatch::find($batch_id);

        $applications = Application::where('quarter_type', $quartertype)
            ->where('batch_id', $batch_id)
            ->orderBy('sono')
            ->get();

        $premises = Premise::where('quarter_type', $quartertype)
            ->where('batch_id',  $batch_id)
            ->orderBy('srno')
            ->get();
        //  dd($applications, $premises, $batch_id, $quartertype);
        return view('draw.verify', [
            'applications' => $applications,
            'premises' => $premises,
            'quartertype' => $quartertype,
            'batch_id' => $batch_id,
            'page_title' => 'Verify Draw Data',
            'page_sub_title' => 'Please Verify Data of Batch Id : ' . $batch->batch_no
        ]);
    }


    public function verifyConfirm(Request $request)
    {
        $quartertype = $request->quartertype;
        $batch_id = $request->batch_id;
        try {
            $appCount = Application::where('quarter_type', $quartertype)->where('batch_id', $batch_id)->count();
            $premCount = Premise::where('quarter_type', $quartertype)->where('batch_id', $batch_id)->count();

            if ($appCount != $premCount) {
                return redirect()->route('draw.history')
                    ->with('error', 'Application and Premise count mismatch');
            }

            DrawBatch::where('quarter_type', $quartertype)
                ->where('id',  $batch_id)
                ->update(['draw_status' => 'verified']);

            DrawLog::create([
                'uid'       => Session::get('officecode'),
                'batch_id'  => $batch_id,
                'operation' => 'VERIFIED',
                'remarks'   => 'Applicant and Premise list verified',
                'ip'        => request()->ip(),
            ]);
            // Session::put('quartertype', $quartertype);

            /* return redirect()->route('draw.index')
            ->with('success', 'Data verified successfully');*/
            return redirect()->route('draw.history')
                ->with('success', 'Data verified successfully');
        } catch (\Exception $e) {
            DrawLog::create([
                'uid'       => Session::get('officecode'),
                'batch_id'  => $batch_id,
                'operation' => 'VERIFIED ISSUE',
                'remarks'   => 'Applicant and Premise list verification issue' . $e->getMessage(),
                'ip'        => request()->ip(),
            ]);
        }
    }
    public function demoDraw(Request $request)
    {
        $quartertype = $request->quartertype;
        $batchId =  $request->batch_id;
        try {
            $batch = DrawBatch::where('id', $batchId)->first();
            //  dd($batch);
            if (!$batch) {
                return back()->with('error', 'Draw batch not found.');
            }

            if ($batch->demo_run_count >= 3) {
                return back()->with('error', 'Mock draw limit reached (Max 3 allowed).');
            }

            // Clear previous demo result for this batch
            //  DrawResult::where('batch_id', $batchId)->delete();

            // Get premises
            $premises = Premise::where('batch_id', $batchId)
                ->pluck('premise_no')
                ->toArray();

            // Get applicants
            $applicants = Application::where('batch_id', $batchId)
                ->pluck('appln_name')
                ->toArray();

            if (count($premises) != count($applicants)) {
                return back()->with('error', 'Premise and Application count mismatch');
            }

            // Randomize applicants
            $applicants = collect($applicants)->shuffle()->values()->toArray();
            $runNo = $batch->demo_run_count + 1;
            foreach ($premises as $index => $premise) {

                DrawResult::create([
                    'batch_id' => $batchId,
                    'quarter_type' => $quartertype,
                    'premise_no' => $premise,
                    'appln_name' => $applicants[$index] ?? null,
                    'draw_date' => now(),
                    'draw_type' => 'demo',
                    'run_no' => $runNo,
                ]);
            }

            // Increase demo count
            $batch->increment('demo_run_count');

            Session::put('quartertype', $quartertype);
            // Load draw results only for this batch
            /*$results = $batchId
            ? DrawResult::where('batch_id', $batchId)->orderBy('id')->get()
            : collect();*/
            if ($batch->draw_status == 'final') {

                $results = DrawResult::where('batch_id', $batchId)
                    ->where('draw_type', 'final')
                    ->orderBy('id')
                    ->get();
            } else {

                $latestRun = DrawResult::where('batch_id', $batchId)
                    ->where('draw_type', 'demo')
                    ->max('run_no');

                $results = DrawResult::where('batch_id', $batchId)
                    ->where('draw_type', 'demo')
                    ->where('run_no', $latestRun)
                    ->orderBy('id')
                    ->get();
            }

            DrawLog::create([
                'uid'       => Session::get('officecode'),
                'batch_id'  => $batchId,
                'operation' => 'Demo Draw ' . $batch->demo_run_count . ' / 3',
                'remarks'   => 'Demo Draw ' . $batch->demo_run_count . ' / 3 has been executed successfully',
                'ip'        => request()->ip(),
            ]);
            // return redirect()->route('draw.index')
            //     ->with('success', 'Demo draw completed');

            $this->viewContent['page_title'] = "Mock Draw of Batch Id : " . $batch->batch_no;
            $this->viewContent['page_sub_title'] = "Mock Run Preview " . $batch->demo_run_count . " / 3 ";
            $this->viewContent['batch'] = $batch;
            $this->viewContent['results'] = $results;
            // dd($this->viewContent);
            return view('draw.demo_preview', $this->viewContent);
        } catch (\Exception $e) {
            DrawLog::create([
                'uid'       => Session::get('officecode'),
                'batch_id'  => $batchId,
                'operation' => 'Demo Draw ' . $batch->demo_run_count . ' / 3 has an issue',
                'remarks'   => 'Demo Draw ' . $batch->demo_run_count . ' / 3 has an  issue ' . $e->getMessage(),
                'ip'        => request()->ip(),
            ]);
        }
    }

    public function finalDraw(Request $request)
    {
        $quartertype = $request->quartertype;
        $batchId = $request->batch_id;
        try {
            $batch = DrawBatch::where('id', $batchId)->first();
            // dd($batch);
            if (!$batch) {
                return back()->with('error', 'Draw batch not found.');
            }

            if ($batch->draw_status == 'final' && $batch->satisfy_with_final == true) {
                //return back()->with('error', 'Final draw already completed');
                return redirect()->route('draw.history')
                    ->with('success', 'Final draw completed. Entries frozen.');
            }

            // Delete previous results for this batch
            DrawResult::where('batch_id', $batchId)
                ->where('draw_type', 'final')
                ->delete();

            $premises = Premise::where('batch_id', $batchId)
                ->pluck('premise_no')
                ->toArray();

            $applicants = Application::where('batch_id', $batchId)
                ->pluck('appln_name')
                ->toArray();

            if (count($premises) != count($applicants)) {
                return back()->with('error', 'Premise and Application count mismatch');
            }

            $applicants = collect($applicants)->shuffle()->values()->toArray();

            foreach ($premises as $index => $premise) {

                DrawResult::create([
                    'batch_id' => $batchId,
                    'quarter_type' => $quartertype,
                    'premise_no' => $premise,
                    'appln_name' => $applicants[$index] ?? null,
                    'draw_date' => now(),
                    'draw_type' => 'final',
                    'run_no' => null,
                ]);
            }
            try {
                $batch->update(['draw_status' => 'final']);
                // dd(updated);
            } catch (\Exception $e) {
                dd($e->getMessage());
            }

            //Session::put('quartertype','');
            /* Reset session after final draw */
            // Session::forget('batch_id');
            // Session::forget('quartertype');


            // return redirect()->route('draw.index')
            //     ->with('success', 'Final draw completed. Entries frozen.');

            //  $results = $batchId
            //     ? DrawResult::where('batch_id', $batchId)->orderBy('id')->get()
            //     : collect();
            $results = DrawResult::where('batch_id', $batchId)
                ->where('draw_type', 'final')
                ->orderBy('id')
                ->get();
            //dd($results);
            // dd($batch);
            DrawLog::create([
                'uid'       => Session::get('officecode'),
                'batch_id'  => $batchId,
                'operation' => 'Final Draw',
                'remarks'   => 'Final Draw of ' . $batchId . ' has been completed',
                'ip'        => request()->ip(),
            ]);

            $this->viewContent['page_title'] = "Final Run Preview";
            $this->viewContent['page_title'] = "Final Draw of Batch Id : " . $batch->batch_no;
            $this->viewContent['page_sub_title'] = "Final Run Preview";
            $this->viewContent['batch'] = $batch;
            $this->viewContent['results'] = $results;
            //  dd($this->viewContent);
            return view('draw.demo_preview', $this->viewContent);
            // return redirect()->route('draw.history')
            //     ->with('success', 'Final draw completed. Entries frozen.');
            //  return redirect()->route('draw.demo')
            //      ->with('success', 'Final draw completed. Entries frozen.');
        } catch (\Exception $e) {
            DrawLog::create([
                'uid'       => Session::get('officecode'),
                'batch_id'  => $batchId,
                'operation' => 'Final Draw Issue',
                'remarks'   => 'Final Draw of ' . $batchId . 'has an issue' . $e->getMessage(),
                'ip'        => request()->ip(),
            ]);
        }
    }


    public function generateFullDrawPdf($batch, Request $request)
    {
        $quartertype = session('quartertype');
        $batchId = session('batch_id');
        $batch = DrawBatch::find($batchId);

        /*$results = DrawResult::where('quarter_type', $quartertype)
            ->where('batch_id', session('batch_id'))
            ->orderBy('id', 'asc')
            ->get();*/
        $type = $request->type ?? 'demo';

        $query = DrawResult::where('batch_id', $batchId)
            ->where('draw_type', $type);

        if ($type == 'demo') {
            $latestRun = $query->max('run_no');
            $query->where('run_no', $latestRun);
        }

        $results = $query->orderBy('id')->get();

        if ($results->isEmpty()) {
            return back()->with('error', 'No draw results found.');
        }

        $data = [
            'results'       => $results,
            'batch_title'   => $batch->batch_title,
            'quarter_type'  => $batch->quarter_type,
            'draw_status'   => $batch->draw_status,
            'generated_at'  => now()->format('d-m-Y h:i:s A')
        ];


        $pdf = Pdf::loadView('draw.full_draw_pdf', $data);

        return $pdf->download('Quarter_Draw_Result.pdf');
    }



    public function exportDrawExcel()
    {
        $batchId = session('batch_id');
        return Excel::download(
            new DrawResultExport($batchId),
            'Quarter_Draw_Result.xlsx'
        );
    }
    public function history()
    {
        $batches = DrawBatch::orderBy('id', 'asc')->get();

        return view('draw.history', [
            'page_title' => 'Quarter Draw',
            'batches' => $batches
        ]);
    }
    public function downloadBatchPdf($batch, Request $request)
    {
        $batchId = $batch;   // route parameter

           // dd($batch,$request->all());
        $type = $request->type;
        $run  = $request->run;

        $draw_status=null;

        $batch = DrawBatch::find($batchId);
        
        try {

            if (!$batch) {
                return back()->with('error', 'Batch not found.');
            }

            // Decide which results to fetch
            if ($type == 'final') {

                // $batch->update(['satisfy_with_final' =>  DB::raw('true')]);

                // dd($batch);
                $results = DrawResult::where('batch_id', $batchId)
                    ->where('draw_type', 'final')
                    ->orderBy('id')
                    ->get();
                $draw_status="final";
            } else {
                
                $results = DrawResult::where('batch_id', $batchId)
                    ->where('draw_type', 'demo')
                    ->where('run_no', $run)
                    ->orderBy('id')
                    ->get();
                    $draw_status="demo";
                   
            }

            if ($results->isEmpty()) {
                return back()->with('error', 'No draw results found.');
            }

            $data = [
                'results'        => $results,
                'batch_no'       => $batch->batch_no,
                'batch_title'    => $batch->batch_title,
                'quarter_type'   => $batch->quarter_type,
              //  'draw_status'    => $batch->draw_status,
                'draw_status' => $draw_status,
                'demo_run_count' => $batch->demo_run_count,
                'draw_date'      => \Carbon\Carbon::parse($batch->draw_date)->format('d-m-Y'),
                'generated_at'   => now()->format('d-m-Y h:i:s A')
            ];

            // remarks
            if ($type == 'final') {
                $remarks = "Final Draw download";
            } else {
                $remarks = "Demo draw run " . $run;
            }

            DrawLog::create([
                'uid'       => Session::get('officecode'),
                'batch_id'  => $batchId,
                'operation' => 'PDF Download',
                'remarks'   => 'Batch Id :' . $batchId . ', pdf, ' . $remarks,
                'ip'        => request()->ip(),
            ]);

            /* $pdf = Pdf::loadView('draw.full_draw_pdf', $data);

        return $pdf->download('Draw_Result_' . $batchId . '.pdf');*/
            /* Render blade to HTML */


            $html = view('draw.full_draw_pdf', $data)->render();

            $mpdf = new \Mpdf\Mpdf([
                'format' => 'A4',
                'orientation' => 'P',
                'margin_top' => 55,   // increase header space
                'margin_bottom' => 25
            ]);

            $statusText = '';

            // if ($batch->draw_status == 'final') {
            //     $statusText = 'Final Draw';
            // } elseif ($batch->draw_status == 'verified') {
            //     $statusText = 'Mock Draw ' . $batch->demo_run_count . ' / 3';
            // }

             if ($draw_status == 'final') {
                $statusText = 'Final Draw';
            } elseif ($draw_status == 'demo') {
                $statusText = 'Mock Draw ' . $run . ' / 3';
            }

            $header = '
<div style="width:100%;">

<table width="100%" style="border:none;">

<tr>
<td width="33%" style="border:none;"></td>
<td width="34%" style="border:none;"></td>

</tr>

<tr>

<td width="33%" style="border:none;">
<img src="' . public_path('images/national_emblem.gif') . '" width="60">
</td>

<td width="50%" align="center" style="border:none;">

<div style="font-size:16px; font-weight:bold;">
Roads & Buildings Department
</div>

<div style="font-size:14px;">
Government of Gujarat
</div>

<div style="font-size:14px; font-weight:bold;">
' . $statusText . '
</div>

</td>

<td width="33%" style="border:none;"></td>

</tr>

<tr>
<td colspan="3" align="right" style="font-size:12px; padding-top:5px; border:none;">
Report Generated On: <b>' . now()->format('d-m-Y h:i A') . '</b>
</td>
</tr>

</table>

</div>
';

            $mpdf->SetHTMLHeader($header);

            $mpdf->SetFooter('Page {PAGENO} / {nbpg}');

            $mpdf->WriteHTML($html);

            $mpdf->Output('Draw_Result_' . $batch->id . '.pdf', 'D');

           
        } catch (\Exception $e) {
            dd($e->getMessage());
            DrawLog::create([
                'uid'       => Session::get('officecode'),
                'batch_id'  => $batchId,
                'operation' => 'PDF Download Issue',
                'remarks'   => 'Batch Id :' . $batchId . ', pdf issue: ' . $e->getMessage(),
                'ip'        => request()->ip(),
            ]);
        }
    }
    public function downloadBatchExcel($batchId)
    {
        $batch = DrawBatch::find($batchId);

        if (!$batch) {
            return back()->with('error', 'Batch not found.');
        }

        $results = DrawResult::where('batch_id', $batchId)
            ->orderBy('id')
            ->get();

        if ($results->isEmpty()) {
            return back()->with('error', 'No draw results found.');
        }

        $data = [
            'results'       => $results,
            'batch_title'   => $batch->batch_title,
            'quarter_type'  => $batch->quarter_type,
            'draw_status'   => $batch->draw_status,
            'generated_at'  => now()->format('d-m-Y h:i:s A')
        ];

        /* $pdf = Pdf::loadView('draw.full_draw_pdf', $data);

        return $pdf->download('Draw_Result_' . $batchId . '.pdf');*/
        // Pass $batchId to the export constructor
        return Excel::download(
            new DrawResultExport($batchId),
            'Quarter_Draw_Result.xlsx'
        );
    }

    public function reset()
    {
        $quartertype = Session::get('quartertype', 'J');
        $batchId = Session::get('batch_id', 1);

        // 1️⃣ Delete previous results for the batch (if any)
        $batch = DrawBatch::where('quarter_type', 'J')
            ->latest()
            ->first();

        if ($batch) {
            $batch->draw_status = 'incomplete';
            $batch->save();
        }
        // 2️⃣ Clear session variables
        Session::forget('batch_id');
        Session::forget('quartertype');

        // 3️⃣ Do NOT create a new batch here — new batch will be created on Excel upload

        return redirect()->route('draw.index')
            ->with('success', 'Session reset successfully. You can now upload a new Excel file to create a fresh batch.');
    }
    public function drawDel(Request $request)
    {
        $quartertype = $request->quartertype;
        $batchId =  $request->batch_id;
        try {
            $batch = DrawBatch::where('id', $batchId)->first();
            // dd($batch);
            if (!$batch) {
                return back()->with('error', 'Draw batch not found.');
            }


            DrawLog::create([
                'uid'       => Session::get('officecode'),
                'batch_id'  => $batchId,
                'operation' => 'Deleted',
                'remarks'   => 'Batch id : ' . $batchId . 'deleted successfully,details are :' . $batch,
                'ip'        => request()->ip(),
            ]);
            // Clear previous demo result for this batch
            DrawResult::where('batch_id', $batchId)->delete();
            DrawBatch::where('id', $batchId)->delete();
            return back()->with('success', 'Draw batch deleted successfully.');
        } catch (\Exception $e) {
            DrawLog::create([
                'uid'       => Session::get('officecode'),
                'batch_id'  => $batchId,
                'operation' => 'Delete ISSUE',
                'remarks'   => 'Batch id : ' . $batchId . 'delete operation has issue:' . $batchId,
                'ip'        => request()->ip(),
            ]);
        }
    }
    public function finalDrawUpdate(Request $request)
    {
        $batchId = $request->batchId;   // route parameter

        $type = $request->type;
        $run  = $request->run;

        $batch = DrawBatch::find($batchId);

        try {

            if (!$batch) {
                return back()->with('error', 'Batch not found.');
            }

            // Decide which results to fetch
            if ($type == 'final') {

                $batch->update(['satisfy_with_final' =>  DB::raw('true')]);
                // call PDF download function
                return $this->downloadBatchPdf($batchId,$request);
            }
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
