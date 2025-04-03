<?php

namespace App\Http\Controllers;

use App\User;
use App\Otp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class PhoneVerificationController extends Controller
{
    /**
     * Display the phone verification page or redirect if already verified.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request)
    {
        // Check if the user is authenticated first
        $user = $request->user();

        if (!$user) {
        // If the user is not authenticated, redirect to login or show an error
        return redirect()->route('login')->withErrors('You must be logged in to verify your phone.');
        }

       // dd($request->user());
        if ($request->user()->hasVerifiedPhone()) {
            User::updateOrCreate(
                ['id' => $request->user()->id], // Attributes to find the user
                [ // Attributes to update or create
                   
                    'email_verified_at' => Carbon::now(),
                ]
            );
            return redirect()->route('home');
        }
       // dd($request->user());
        // Call the method to generate and send OTP to the user's phone
      // $this->callToVerify($request->user());
      // Generate OTP and send it to the user
      $otp = Otp::generateOtpForUser($user);
     // $otp=123456;
      Otp::sendOtpToUser($user->contact_no, $otp->otp);

        // Return the OTP verification view
        return view('auth.otp-verification');
    }

    /**
     * Verify the OTP entered by the user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function verify(Request $request)
{
    // Validate the OTP input from the user
    $request->validate([
        'otpnumber' => 'required|numeric|digits:6', // OTP validation
    ]);

    // Get the user from the session if available
    $user = session('user') ?? $request->user();  // Try to get user from session or request
    //dd( $user);
    if (!$user) {
        // If user is not authenticated or session is expired, redirect back to login
        return redirect()->route('login')->withErrors('Session expired. Please log in again.');
    }

    // Retrieve the most recent OTP record for the user
    $otp = Otp::where('user_id', $user->id)->latest()->first();

    // If OTP is not found or has expired
    if (!$otp || now()->greaterThan($otp->expires_at)) {
        return redirect()->back()->withErrors([
            'code' => 'The OTP you provided is invalid or has expired. Please try again.'
        ]);
    }

    // Reset failed attempts if the lockout period has expired
    if ($otp->blocked_until && now()->greaterThan($otp->blocked_until)) {
        $otp->attempts = 0;  // Reset attempts
        $otp->blocked_until = null;  // Unlock account
        $otp->save();
    }

    // If the OTP is locked due to too many failed attempts
    if ($otp->blocked_until && now()->lessThan($otp->blocked_until)) {
        return redirect()->back()->withErrors([
            'code' => 'Too many failed attempts. Your account is temporarily locked. Please try again later.'
        ]);
    }

    // If OTP is incorrect, increment the attempt count
    if ($otp->otp !== $request->otpnumber) {
        $otp->increment('attempts');

        // Lock the account for 30 minutes after 3 failed attempts
        if ($otp->attempts >= 3) {
            $otp->blocked_until = now()->addMinutes(30);  // Lock for 30 minutes
            $otp->save();
            return redirect()->back()->withErrors([
                'code' => 'Too many failed attempts. Your account has been temporarily locked for 30 minutes.'
            ]);
        }

        return redirect()->back()->withErrors([
            'code' => 'The OTP you provided is incorrect. Please try again or request another OTP.'
        ]);
    }

    // If OTP is correct, proceed to phone verification
    $this->phoneVerifiedAt($user);  // Mark the phone as verified

    // Delete the OTP after successful verification
    $otp->delete();

    // Log the user in
     // Log the user in
     Auth::login($user);

     // Regenerate session to ensure a fresh one
     session()->regenerate();
        /// Check if user is authenticated after login
        if (Auth::check()) {
            session()->forget('user');
        // dd('User is authenticated:', Auth::user());
        } else {
        // dd('User is not authenticated after login');
        }

    // Redirect to the home page or the intended page after successful login
    return redirect()->route('home')->with('status', 'Your phone was successfully verified!');
}


    /**
     * Generate and send OTP to the user's phone.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function callToVerify(User $user)
    {
        // Ensure that the user is authenticated
        if (!$user) {
            Log::error('User not authenticated.');
            return;
        }

        // Check if the user already has an OTP (not expired)
        $otp = Otp::where('user_id', $user->id)->first();

        // If OTP doesn't exist or it has expired, generate a new one
        if (!$otp || now()->greaterThan($otp->expires_at)) {
            // Generate a 6-digit OTP
            $otp = rand(100000, 999999); // You can adjust the length or format of OTP as required

            // Set the expiration time for the OTP (e.g., 10 minutes)
            $expiresAt = now()->addMinutes(10);

            // Create the OTP record in the database
            Otp::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'mobile_no' => $user->contact_no,  // Assuming contact_no is stored in the users table
                    'otp' => $otp,
                    'expires_at' => $expiresAt,
                    'attempts' => 0, // Initially no failed attempts
                ]
            );
        } else {
            // If OTP exists and is not expired, update the expiration time
            $otp->expires_at = now()->addMinutes(10);  // Extend expiration by 10 minutes
            $otp->save();
        }

        // Send the OTP to the user's phone (you can customize this method to use your SMS gateway)
        $this->sendOtpToPhone($user->contact_no, $otp);
    }


    /**
     * Send OTP to the user's phone number.
     *
     * @param string $mobileNo
     * @param string $otp
     * @return void
     */
    public function sendOtpToPhone($mobileNo, $otp)
    {
        // You can replace this with actual SMS sending logic (e.g., using Twilio, Nexmo, or your custom gateway)
        $message = "Your OTP is: $otp. This OTP will expire in 10 minutes.";

        // Example of sending an OTP via your SMS gateway (replace with your logic)
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://localhost:8021/send?receiverid=$mobileNo&msg=" . base64_encode($message));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $body = curl_exec($ch);
        curl_close($ch);

        // Log or handle the response as needed
        Log::info("OTP sent to $mobileNo: $message");
    }

    /**
     * Mark the user's phone as verified by updating the phone_verified_at timestamp.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function phoneVerifiedAt(User $user)
    {
        // Update the `phone_verified_at` timestamp to mark the phone as verified
        return $user->forceFill([
            'phone_verified_at' => now(),
            'email_verified_at' => Carbon::now()
        ])->save();
    }
}
