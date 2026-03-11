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

            $batch_no = $quartertype.'/'.$date.'/'.$random;
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
                'remarks'   => 'Applicant and Premise list uploaded has an issue'.$e->getMessage(),
                'ip'        => request()->ip(),
            ]);
            dd($e->getMessage(), $e->getLine());
        }
    }



    public function verifyPreview___old(Request $request)
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

    public function verifyPreview(Request $request)
    {
        $quartertype = $request->quartertype;
        $batch_id = $request->batch_id;
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
            'page_title' => 'Verify Data'
        ]);
    }

    public function verifyConfirm__old(Request $request)
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

        /* return redirect()->route('draw.index')
            ->with('success', 'Data verified successfully');*/
        return redirect()->route('draw.history')
            ->with('success', 'Data verified successfully');
    }
    public function verifyConfirm(Request $request)
    {
        $quartertype = $request->quartertype;
        $batch_id = $request->batch_id;
        try{
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
        }
        catch(\Exception $e)
        {
              DrawLog::create([
                'uid'       => Session::get('officecode'),
                'batch_id'  => $batch_id,
                'operation' => 'VERIFIED ISSUE',
                'remarks'   => 'Applicant and Premise list verification issue'.$e->getMessage(),
                'ip'        => request()->ip(),
            ]);
        }
    }


    public function demoDraw__old(Request $request)
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
        // Load draw results only for this batch
        $results = $batchId
            ? DrawResult::where('batch_id', $batchId)->orderBy('id')->get()
            : collect();
        // return redirect()->route('draw.index')
        //     ->with('success', 'Demo draw completed');
        $this->viewContent['page_title'] = "Demo Preview";
        $this->viewContent['batch'] = $batch;
        $this->viewContent['results'] = $results;
        return view('draw.demo_preview', $this->viewContent);
    }

    public function demoDraw(Request $request)
    {
        $quartertype = $request->quartertype;
        $batchId =  $request->batch_id;
        try {
        $batch = DrawBatch::where('id', $batchId)->first();
        // dd($batch);
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
        // Load draw results only for this batch
        $results = $batchId
            ? DrawResult::where('batch_id', $batchId)->orderBy('id')->get()
            : collect();
            
            DrawLog::create([
                'uid'       => Session::get('officecode'),
                'batch_id'  => $batchId,
                'operation' => 'Demo Draw '.$batch->demo_run_count.' / 3',
                'remarks'   => 'Demo Draw '.$batch->demo_run_count.' / 3 has been executed successfully',
                'ip'        => request()->ip(),
            ]);
        // return redirect()->route('draw.index')
        //     ->with('success', 'Demo draw completed');
        $this->viewContent['page_title'] = "Demo Run Preview ".$batch->demo_run_count." / 3 ";
        $this->viewContent['batch'] = $batch;
        $this->viewContent['results'] = $results;
        return view('draw.demo_preview', $this->viewContent);
        }
        catch(\Exception $e)
        {
              DrawLog::create([
                'uid'       => Session::get('officecode'),
                'batch_id'  => $batchId,
                'operation' => 'Demo Draw '.$batch->demo_run_count.' / 3 has an issue',
                'remarks'   => 'Demo Draw '.$batch->demo_run_count.' / 3 has an  issue '.$e->getMessage(),
                'ip'        => request()->ip(),
            ]);
        }
    }




    public function finalDraw__old(Request $request)
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


        // return redirect()->route('draw.index')
        //     ->with('success', 'Final draw completed. Entries frozen.');

        //  $results = $batchId
        //     ? DrawResult::where('batch_id', $batchId)->orderBy('id')->get()
        //     : collect();
        // $this->viewContent['page_title'] = "Final Run Preview";
        // $this->viewContent['batch'] = $batch;
        // $this->viewContent['results'] = $results;
        // return view('draw.demo_preview', $this->viewContent);

        // return redirect()->route('draw.history')
        //     ->with('success', 'Final draw completed. Entries frozen.');
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

        if ($batch->draw_status == 'final') {
            //return back()->with('error', 'Final draw already completed');
            return redirect()->route('draw.history')
            ->with('success', 'Final draw completed. Entries frozen.');
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
        try{
        $batch->update(['draw_status' => 'final']);
       // dd(updated);
        }
        catch(\Exception $e)
        {
            dd($e->getMessage());
        }

        //Session::put('quartertype','');
        /* Reset session after final draw */
        // Session::forget('batch_id');
        // Session::forget('quartertype');


        // return redirect()->route('draw.index')
        //     ->with('success', 'Final draw completed. Entries frozen.');

         $results = $batchId
            ? DrawResult::where('batch_id', $batchId)->orderBy('id')->get()
            : collect();
        //dd($results);
       // dd($batch);
        DrawLog::create([
                'uid'       => Session::get('officecode'),
                'batch_id'  => $batchId,
                'operation' => 'Final Draw',
                'remarks'   => 'Final Draw of '.$batchId.' has been completed',
                'ip'        => request()->ip(),
            ]);

         $this->viewContent['page_title'] = "Final Run Preview";
        $this->viewContent['batch'] = $batch;
        $this->viewContent['results'] = $results;
      //  dd($this->viewContent);
       return view('draw.demo_preview', $this->viewContent);
        // return redirect()->route('draw.history')
        //     ->with('success', 'Final draw completed. Entries frozen.');
        //  return redirect()->route('draw.demo')
        //      ->with('success', 'Final draw completed. Entries frozen.');
        }
        catch(\Exception $e)
        {
            DrawLog::create([
                'uid'       => Session::get('officecode'),
                'batch_id'  => $batchId,
                'operation' => 'Final Draw Issue',
                'remarks'   => 'Final Draw of '.$batchId.'has an issue'.$e->getMessage(),
                'ip'        => request()->ip(),
            ]);
        }
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
        $batches = DrawBatch::orderBy('id', 'asc')->get();

        return view('draw.history', [
            'page_title' => 'Quarter Draw',
            'batches' => $batches
        ]);
    }
    public function downloadBatchPdf($batchId)
    {
        $batch = DrawBatch::find($batchId);
        try {
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
            'batch_no'      => $batch->batch_no,
            'batch_title'   => $batch->batch_title,
            'quarter_type'  => $batch->quarter_type,
            'draw_status'   => $batch->draw_status,
            'demo_run_count' => $batch->demo_run_count,
            'generated_at'  => now()->format('d-m-Y h:i:s A')
        ];
        $remarks=null;
        if($batch->draw_status=='final')
        {
                $remarks="Final Draw download";
        }
        else if($batch->draw_status=='verified')
         {
            $remarks="Demo draw of ".$batch->demo_run_count." / 3";
         }
        DrawLog::create([
                'uid'       => Session::get('officecode'),
                'batch_id'  => $batchId,
                'operation' => 'PDF Download',
                'remarks'   => 'Batch Id :'.$batchId.', pdf, '.$remarks,
                'ip'        => request()->ip(),
            ]);
        $pdf = Pdf::loadView('draw.full_draw_pdf', $data);

        return $pdf->download('Draw_Result_' . $batchId . '.pdf');
        }
        catch(\Exception $e)
        {
             DrawLog::create([
                'uid'       => Session::get('officecode'),
                'batch_id'  => $batchId,
                'operation' => 'PDF Download Issue',
                'remarks'   => 'Batch Id :'.$batchId.', pdf has been download issue'.$remarks.','.$e->getMessage(),
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
                'remarks'   => 'Batch id : '.$batchId.'deleted successfully,details are :'.$batch,
                'ip'        => request()->ip(),
            ]);
		 // Clear previous demo result for this batch
        DrawResult::where('batch_id', $batchId)->delete();
        DrawBatch::where('id',$batchId)->delete();
        return back()->with('success', 'Draw batch deleted successfully.');
        }
        catch(\Exception $e)
        {
            DrawLog::create([
                'uid'       => Session::get('officecode'),
                'batch_id'  => $batchId,
                'operation' => 'Delete ISSUE',
                'remarks'   => 'Batch id : '.$batchId.'delete operation has issue:'.$batchId,
                'ip'        => request()->ip(),
            ]);
        }
    }
}
