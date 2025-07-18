<?php

namespace App\Http\Controllers;

use App\User;
use App\Otp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;

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
        //dd($user);
        if (!$user) {
        // If the user is not authenticated, redirect to login or show an error
        return redirect()->route('login')->withErrors('You must be logged in to verify your phone.');
        }

       // dd($request->user());
      /*  if ($request->user()->hasVerifiedPhone()) {
            User::updateOrCreate(
                ['id' => $request->user()->id], // Attributes to find the user
                [ // Attributes to update or create
                   
                    'email_verified_at' => Carbon::now(),
                ]
            );
            return redirect()->route('home');
        }*/
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
    $MAX_ATTEMPTS = 3;
    $LOCKOUT_MINUTES = 30;

   // Log::info('OTP verification initiated', ['request_data' => $request->all()]);

    // Validate OTP
    $request->validate([
        'otpnumber' => 'required|numeric|digits:6',
    ]);

    // Get user from session (this must be set in sendOtp())
    $user = session('user');

    if (!$user) {
        //Log::warning('OTP verification failed: User session expired.');
        return redirect()->route('login')->withErrors('Session expired. Please log in again.');
    }

    //Log::info('User from session', ['user_id' => $user->id]);

    // Fetch latest OTP
    $otp = Otp::where('user_id', $user->id)->latest()->first();

    if (!$otp) {
      //  Log::warning('No OTP found for user', ['user_id' => $user->id]);
        return redirect()->back()->withErrors(['otpnumber' => 'OTP not found.']);
    }

    if (now()->greaterThan($otp->expires_at)) {
       // Log::warning('OTP expired', ['user_id' => $user->id, 'expired_at' => $otp->expires_at]);
        return redirect()->back()->withErrors(['otpnumber' => 'OTP has expired.']);
    }

    // Lockout check
    if ($otp->blocked_until && now()->lessThan($otp->blocked_until)) {
       /* Log::warning('User temporarily blocked due to too many attempts', [
            'user_id' => $user->id,
            'blocked_until' => $otp->blocked_until
        ]);*/
        return redirect()->back()->withErrors(['otpnumber' => 'Too many attempts. Try again later.']);
    }

    // OTP mismatch
    if ($otp->otp !== $request->otpnumber) {
        $otp->increment('attempts');
        /*Log::warning('OTP mismatch', [
            'user_id' => $user->id,
            'attempts' => $otp->attempts
        ]);*/

        if ($otp->attempts >= $MAX_ATTEMPTS) {
            $otp->update(['blocked_until' => now()->addMinutes($LOCKOUT_MINUTES)]);
          /*  Log::error('User blocked due to max attempts', [
                'user_id' => $user->id,
                'blocked_until' => $otp->blocked_until
            ]);*/
            return redirect()->back()->withErrors(['otpnumber' => "Too many failed attempts. Locked for {$LOCKOUT_MINUTES} minutes."]);
        }

        return redirect()->back()->withErrors(['otpnumber' => 'Incorrect OTP.']);
    }

    // OTP matched
    $otp->update([
        'attempts' => 0,
        'blocked_until' => null,
    ]);
   // Log::info('OTP verified successfully', ['user_id' => $user->id]);

    // Create a unique session ID to track the user's session
    $newSessionId = (string) Str::uuid();

    // Update the user session info
    $user->update([
        'session_status' => 1,
        'session_id' => $newSessionId,
    ]);

    session(['user_session_id' => $newSessionId]);

    // Log the user in
    Auth::login($user);

   
   $this->phoneVerifiedAt($user);
    return redirect()->route('home')->with('status', 'Login successful!');
}
    public function callToVerify(User $user)
    {
        // Ensure that the user is authenticated
        if (!$user) {
            // Log::error('User not authenticated.');
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
        // Log::info("OTP sent to $mobileNo: $message");
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
            'phone_verified_at' => now()
          
        ])->save();
    }
}
