<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Premise;
use App\Models\Application;
use App\Models\DrawResult;

class DrawController extends Controller
{
    public function runDraw()
    {
        DB::beginTransaction();

        try {

            // Get Premise numbers
            $premises = Premise::pluck('premise_no')->toArray();

            // Get Applicant names
            $applicants = Application::pluck('appln_name')->toArray();

            // Check equal count
            if (count($premises) != count($applicants)) {
                return back()->with('error', 'Premise and Applicant count mismatch');
            }

            // Randomize applicants
            $applicants = collect($applicants)->shuffle()->values()->toArray();

            foreach ($premises as $index => $premise) {

                DrawResult::create([
                    'premise_no' => $premise,
                    'appln_name' => $applicants[$index],
                    'draw_date'  => now()
                ]);
            }

            DB::commit();

            return back()->with('success', 'Draw completed successfully');

        } catch (\Exception $e) {

            DB::rollBack();
            return back()->with('error', 'Draw failed');
        }
    }
}