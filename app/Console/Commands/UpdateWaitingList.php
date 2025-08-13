<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UpdateWaitingList extends Command
{
    protected $signature = 'waitinglist:update';
    protected $description = 'Update waiting list and handle retirement deactivations';

    public function handle()
    {   
      $quarterTypes = DB::table('master.m_quarter_type')
    ->select('quartertype')
    ->whereIn('quartertype', ['J', 'K'])
    ->pluck('quartertype');

        foreach ($quarterTypes as $q) {
            // Reset r_wno for non-priority requests
            DB::table('master.t_quarter_request_a')
                ->where('quartertype', $q)
                ->where('is_priority', 'N')
                ->whereNotNull('wno')
                ->update(['r_wno' => null]);

            DB::table('master.t_quarter_request_b')
                ->where('quartertype', $q)
                ->where('is_priority', 'N')
                ->whereNotNull('wno')
                ->update(['r_wno' => null]);

            // Get active requests without office remarks
            $requests = DB::select("
                SELECT wno, uid, office_remarks
                FROM master.t_quarter_request_a
                WHERE quartertype = ? AND is_priority = 'N' AND wno IS NOT NULL AND is_withdraw = 'N' AND office_remarks IS NULL
                UNION
                SELECT wno, uid, office_remarks
                FROM master.t_quarter_request_b
                WHERE quartertype = ? AND is_priority = 'N' AND wno IS NOT NULL AND is_withdraw = 'N' AND office_remarks IS NULL
                ORDER BY wno
            ", [$q, $q]);

            foreach ($requests as $re) {
			$uid = $re->uid;
			$today = now()->toDateString();

			$retirement = DB::table('userschema.users')
				->where('id', $uid)
				->where('is_activated', 1)
				->where(function ($q) use ($today) {
				$q->whereDate('date_of_retirement', '<', $today)
				->orWhereNull('date_of_retirement');
				})
			->first();

                if ($retirement) {
                    // Deactivate requests
                    DB::table('master.t_quarter_request_a')
                        ->where('quartertype', $q)
                        ->where('is_priority', 'N')
                        ->whereNotNull('wno')
                        ->where('uid', $uid)
                        ->update(['r_wno' => null]);

                    DB::table('master.t_quarter_request_b')
                        ->where('quartertype', $q)
                        ->where('is_priority', 'N')
                        ->whereNotNull('wno')
                        ->where('uid', $uid)
                        ->update(['r_wno' => null]);

                    DB::table('userschema.users')
                        ->where('id', $uid)
                        ->update(['is_activated' => 0]);

                    Log::info("Request deactivated for UID {$uid} due to retirement	1111111111111111111");

                } else {
                    // Assign new r_wno
                    $maxA = DB::table('master.t_quarter_request_a')
                        ->where('quartertype', $q)
                        ->where('is_priority', 'N')
                        ->whereNotNull('wno')
                        ->whereNotNull('r_wno')
                        ->max('r_wno');

                    $maxB = DB::table('master.t_quarter_request_b')
                        ->where('quartertype', $q)
                        ->where('is_priority', 'N')
                        ->whereNotNull('wno')
                        ->whereNotNull('r_wno')
                        ->max('r_wno');

                    $lastWno = max($maxA ?? 0, $maxB ?? 0);
                    $newWno = $lastWno + 1;
					Log::info("Rwno for quartertype  {$q} UID {$uid} new {$newWno} ");
                    DB::table('master.t_quarter_request_a')
                        ->where('quartertype', $q)
                        ->where('is_priority', 'N')
                        ->whereNotNull('wno')
                        ->where('wno', $re->wno)
                        ->update(['r_wno' => $newWno]);

                    DB::table('master.t_quarter_request_b')
                        ->where('quartertype', $q)
                        ->where('is_priority', 'N')
                        ->whereNotNull('wno')
                        ->where('wno', $re->wno)
                        ->update(['r_wno' => $newWno]);
                }
            }
        }

        $this->info('Waiting list updated successfully.');
    }
}
