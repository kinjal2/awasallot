<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str; 
use App\User;
use App\Otp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;

class LoginController extends Controller
{
    use \Illuminate\Foundation\Auth\AuthenticatesUsers;

    protected $redirectTo = '/checkuser';

    public function __construct()
    {
        //$this->middleware('guest')->except('logout');
    }

    // Show the OTP login form
    public function showOtpLoginForm()
    {
        return view('auth.otp-login');
    }

    // Send OTP to the user's phone or email
    public function sendOtp(Request $request)
{
    // Step 1: Validate input
    $request->validate([
        'identifier' => 'required', // mobile or email
        'captcha' => 'required|captcha',
    ]);

    // Step 2: Get user by mobile or email
    $user = User::where('contact_no', $request->identifier)
                ->orWhere('email', $request->identifier)
                ->first();

    if (!$user) {
        return back()->withErrors(['identifier' => 'User not found.']);
    }

    // Step 3: Invalidate any existing session
    if ($user->session_status === 1) {
        $user->update([
            'session_status' => 0,
            'session_id' => null,
        ]);
    }

    // Step 4: Generate new session ID and store temporarily
    $newSessionId = Str::uuid()->toString();
    session([
        'pending_session_id' => $newSessionId,
        'user' => $user,
    ]);

    // Step 5: Generate and send OTP
    $otp = Otp::generateOtpForUser($user);
    Otp::sendOtpToUser($user->contact_no, $otp->otp);

    // Step 6: Redirect to OTP form
    return redirect()->route('otp.verification.form');
}

    public function otpVerification(Request $request)
    {

        $user = session('user');
       if (!$user) {
        // If the user is not authenticated, redirect to login or show an error
            return redirect()->route('login')->withErrors('You must be logged in to verify your phone.');
        }

        //session()->forget('user');  // Clears the user from the session
        // Return the OTP verification view
        return view('auth.otp-verification');
    }

    // Show OTP verification form
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|numeric|digits:6',
        ]);
        $user = session('user');
      //  dd( $user);
        // Retrieve OTP from the database
        $otp = Otp::where('user_id', $request->user_id)->first();

        if (!$otp || $otp->otp !== $request->otp || now()->greaterThan($otp->expires_at)) {
            return redirect()->back()->withErrors(['otp' => 'The OTP is invalid or expired.']);
        }

        // Login the user
        $user = User::find($otp->user_id);
        Auth::login($user);

        // Delete the OTP record after successful verification
        $otp->delete();

        // Redirect to the home page or the intended page
        return redirect()->route('checkuser');
    }

    // Send OTP to the user's email address
    public function sendOtpToEmail($email, $otp)
    {
        // Send the OTP to the user's email
        \Mail::to($email)->send(new \App\Mail\OtpMail($otp));
        // Log::info("OTP sent to email: $email");
    }

    // Send OTP to the user's phone number (SMS gateway)
    public function sendOtpToPhone($mobileNo, $otp)
    {
        // Implement the SMS gateway logic here
        $message = "Your OTP is: $otp. It will expire in 10 minutes.";
        // Example using a fictional SMS API
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://sms.gateway/send?to=$mobileNo&msg=" . base64_encode($message));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_exec($ch);
        curl_close($ch);

        // Log::info("OTP sent to phone: $mobileNo");
    }

    // Handle user logout
    public function logout(Request $request)
{
    $user = Auth::user();

    if ($user) {
        $user->update([
            'session_status' => 0,
            'session_id' => null,
        ]);
    }

    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/login');
}

}
