<?php

namespace App\Http\Controllers;

use App\User;
use App\Otp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Log;

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
        // If the user has already verified their phone, redirect them to the home page
        if ($request->user()->hasVerifiedPhone()) {
            return redirect()->route('home');
        }
       // dd($request->user());
        // Call the method to generate and send OTP to the user's phone
       $this->callToVerify($request->user());

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
            'captcha' => 'required|captcha', // CAPTCHA validation
        ]);

        // Get the OTP record from the database
        $otp = Otp::where('user_id', $request->user()->id)
        //  ->where('otp', $request->otpnumber)
            ->first();

        // If no OTP found or it has expired
        if (!$otp || now()->greaterThan($otp->expires_at)) {
            return Redirect::back()->withErrors([
                'code' => ['The OTP you provided is invalid or has expired. Please try again.'],
            ]);
        }

        // Reset failed attempts if the lockout period has expired
        if ($otp->blocked_until && now()->greaterThan($otp->blocked_until)) { 
            $otp->attempts = 0;  // Reset attempts
            $otp->blocked_until = null;  // Unlock account
            $otp->save();
        }

        // Check if the OTP is locked (if 'blocked_until' is set and the lock time has not passed)
        if ($otp->blocked_until && now()->lessThan($otp->blocked_until)) {
            return Redirect::back()->withErrors([
                'code' => ['Too many failed attempts. Your account is temporarily locked. Please try again later.'],
            ]);
        }

        // If OTP is incorrect, increase the attempt count
        if ($otp->otp !== $request->otpnumber) {
            $otp->increment('attempts');

            // Lock the account for 30 minutes after 3 failed attempts
            if ($otp->attempts >= 3) {
                $otp->blocked_until = now()->addMinutes(30);  // Lock for 30 minutes
                $otp->save();

                return Redirect::back()->withErrors([
                    'code' => ['Too many failed attempts. Your account has been temporarily locked for 30 minutes.'],
                ]);
            }

            return Redirect::back()->withErrors([
                'code' => ['The code you provided is wrong. Please try again or request another OTP.'],
            ]);
        }

        // If OTP is correct, proceed to phone verification
        $this->phoneVerifiedAt($request->user());

        // Delete the OTP after successful verification
        $otp->delete();

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
        ])->save();
    }
}
