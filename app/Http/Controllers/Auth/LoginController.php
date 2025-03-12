<?php namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Providers\RouteServiceProvider;

class LoginController extends Controller
{
    use \Illuminate\Foundation\Auth\AuthenticatesUsers;

    protected $redirectTo = '/checkuser';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        // Debugging the session ID and user session status
        Log::debug('Current Session ID: ' . session()->getId());
        Log::debug('Stored Session Status in DB: ' . $user->session_status);

        // Check if the user already has an active session
        if ($user->session_status === 1) {
            // If the user already has an active session, log them out
            Log::debug('User already has an active session, logging them out.');
            Auth::logout();
            
            // Flashing session message
            session()->flash('error', 'You are already logged in from another device.');
            
            // Redirect to login page
            return redirect()->route('login');
        }

        // Set the session status to active (1) after login
        $user->session_status = 1;
        $user->save();

        // Regenerate session ID to prevent session fixation attacks
        session()->regenerate();

        // Redirect to the intended route (e.g., dashboard or checkuser)
        return redirect()->route('checkuser');
    }

    /**
     * Handle the user logout.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        $user = Auth::user();

        // Set the session_status to 0 when the user logs out (session is inactive)
        if ($user) {
            $user->session_status = 0;
            $user->save();
        }

        // Perform the actual logout
        Auth::logout();

        // Invalidate the session
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
