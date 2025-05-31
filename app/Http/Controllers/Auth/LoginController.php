<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
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

        try {
            // Validate the mobile number or email and captcha
            $request->validate([
                'identifier' => 'required', // Could be email or mobile number
                'captcha' => 'required|captcha', // Validate CAPTCHA
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Log the validation errors

           // Log::error('Validation errors occurred:', ['context' => $e->errors()]);

            // Optionally, return the error messages to the user
            return back()->withErrors($e->errors());
        }

        // Log the request data if validation passes
        // Log::info('Request Data:', ['context' => $request->all()]);

        // Check if the user exists using either mobile number or email
        $user = User::where('contact_no', $request->identifier)
                    ->orWhere('email', $request->identifier)
                    ->first();

        // Log user data
        // Log::info('User found:', $user ? $user->toArray() : 'No user found');

        // If no user is found, return with error
        if (!$user) {
            return back()->withErrors(['identifier' => 'User not found.']);
        }

        // Store the user in session
        session(['user' => $user]);

        // Call the OTP generation method for the user
        $otp = Otp::generateOtpForUser($user);

        // Send OTP to the user via SMS (or any other communication method you use)
        Otp::sendOtpToUser($user->contact_no, $otp->otp);

        // Redirect to the OTP verification page with the user ID or other necessary data
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

        // Set session_status to 0 on logout (session is inactive)
        if ($user) {
            $user->update(['session_status' => 0]); // Reset session status on logout
        }

        // Perform the actual logout
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

        return redirect('/login');
    }
}
