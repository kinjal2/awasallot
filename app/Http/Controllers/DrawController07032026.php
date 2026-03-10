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
        dd($status);
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
            'file' => 'required|file|mimes:xls,xlsx|max:100'

        ]);

        $file = $request->file('file');

        $spreadsheet = IOFactory::load($file->getRealPath());

        $sheetNames = $spreadsheet->getSheetNames();
        //dd($sheetNames);
        if (count($sheetNames) != 2) {
            return back()->with('error', 'Excel must contain exactly 2 sheets');
        }
        $sheetName = 'beneficiary';
$sheetNames = array_map('trim', $spreadsheet->getSheetNames());

// if (in_array($sheetName, $sheetNames)) {
//     $sheet = $spreadsheet->getSheetByName($sheetName);
// } else {
//     return redirect()->back()->with('error', "Sheet [$sheetName] not found in the Excel file.");
// }
        $sheetNames = array_map('strtolower', $sheetNames);
        //dd($sheetNames);
        if ($sheetNames[0] != 'beneficiary' || $sheetNames[1] != 'premise') {
            return back()->with('error', 'Sheet names must be Beneficiary and Premise');
        }

        try {

            DB::beginTransaction();

            $quartertype = $request->quartertype;

            Application::where('quarter_type', $quartertype)->delete();
            Premise::where('quarter_type', $quartertype)->delete();


            /*   $batch =DrawBatch::updateOrCreate(
    ['quarter_type'=>$quartertype],
    [
        'batch_title'=>$request->batch_title,
        'draw_status'=>'uploaded',
        'demo_run_count'=>0
    ]
);*/
            $batch = DrawBatch::create([
                'quarter_type' => $quartertype,
                'batch_title' => $request->batch_title,
                'draw_status' => 'uploaded',
                'demo_run_count' => 0
            ]);
            $batchId = $batch->id;

            Excel::import(new \App\Imports\DrawMultiSheetImport($batchId, $request->quartertype), $request->file('file'));
            Session::put('batch_id', $batchId);
            Session::put('quartertype', $request->quartertype);

            DB::commit();

            Session::put('quartertype', $quartertype);

            return redirect()->route('draw.index')
                ->with('success', 'Excel Uploaded Successfully. Click on Verify Data');
        } catch (\Throwable $e) {

            DB::rollBack();

            dd($e->getMessage(), $e->getLine());
        }
    }



    public function verifyPreview(Request $request)
    {
        $quartertype = $request->quartertype;

        $applications = Application::where('quarter_type', $quartertype)
            ->where('batch_id', session('batch_id'))
            ->orderBy('sono')
            ->get();

        $premises = Premise::where('quarter_type', $quartertype)
            ->where('batch_id', session('batch_id'))
            ->orderBy('srno')
            ->get();

        return view('draw.verify', [
            'applications' => $applications,
            'premises' => $premises,
            'quartertype' => $quartertype,
            'page_title' => 'Verify Data'
        ]);
    }



    public function verifyConfirm(Request $request)
    {
        $quartertype = $request->quartertype;

        $appCount = Application::where('quarter_type', $quartertype)->where('batch_id', session('batch_id'))->count();
        $premCount = Premise::where('quarter_type', $quartertype)->where('batch_id', session('batch_id'))->count();

        if ($appCount != $premCount) {
            return redirect()->route('draw.index')
                ->with('error', 'Application and Premise count mismatch');
        }

        DrawBatch::where('quarter_type', $quartertype)
            ->where('id', session('batch_id'))
            ->update(['draw_status' => 'verified']);

        Session::put('quartertype', $quartertype);

        return redirect()->route('draw.index')
            ->with('success', 'Data verified successfully');
    }



    public function demoDraw(Request $request)
    {
        $quartertype = $request->quartertype;
        $batchId = session('batch_id');

        $batch = DrawBatch::where('id', $batchId)->first();

        if (!$batch) {
            return back()->with('error', 'Draw batch not found.');
        }

        if ($batch->demo_run_count >= 3) {
            return back()->with('error', 'Demo draw limit reached (Max 3 allowed).');
        }

        // Clear previous demo result for this batch
        DrawResult::where('batch_id', $batchId)->delete();

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

        foreach ($premises as $index => $premise) {

            DrawResult::create([
                'batch_id' => $batchId,
                'quarter_type' => $quartertype,
                'premise_no' => $premise,
                'appln_name' => $applicants[$index] ?? null,
                'draw_date' => now(),
            ]);
        }

        // Increase demo count
        $batch->increment('demo_run_count');

        Session::put('quartertype', $quartertype);

        return redirect()->route('draw.index')
            ->with('success', 'Demo draw completed');
    }



    public function finalDraw(Request $request)
    {
        $quartertype = $request->quartertype;
        $batchId = session('batch_id');

        $batch = DrawBatch::where('id', $batchId)->first();

        if (!$batch) {
            return back()->with('error', 'Draw batch not found.');
        }

        if ($batch->draw_status == 'final') {
            return back()->with('error', 'Final draw already completed');
        }

        // Delete previous results for this batch
        DrawResult::where('batch_id', $batchId)->delete();

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
                'draw_date' => now()
            ]);
        }

        $batch->update(['draw_status' => 'final']);

        //Session::put('quartertype','');
        /* Reset session after final draw */
        Session::forget('batch_id');
        Session::forget('quartertype');


        return redirect()->route('draw.index')
            ->with('success', 'Final draw completed. Entries frozen.');
    }

    public function generateFullDrawPdf()
    {
        $quartertype = session('quartertype');
        $batchId = session('batch_id');
        $batch = DrawBatch::find($batchId);

        $results = DrawResult::where('quarter_type', $quartertype)
            ->where('batch_id', session('batch_id'))
            ->orderBy('id', 'asc')
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
        $batches = DrawBatch::orderBy('id', 'desc')->get();

        return view('draw.history', [
            'page_title' => 'Draw History',
            'batches' => $batches
        ]);
    }
    public function downloadBatchPdf($batchId)
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

        $pdf = Pdf::loadView('draw.full_draw_pdf', $data);

        return $pdf->download('Draw_Result_' . $batchId . '.pdf');
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
        $batchId = Session::get('batch_id',1);

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
}
