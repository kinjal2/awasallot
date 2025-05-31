<?php 
namespace App\Listeners;

use Illuminate\Session\Events\SessionExpired;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class HandleSessionExpiration
{
    public function handle(SessionExpired $event)
    {
        if (auth()->check()) {
            $user = auth()->user();
            $user->update(['session_status' => 0]); // Reset session_status on expiration
            Log::info("Session expired for user ID: {$user->id}, session_status reset.");
        }
    }
}
