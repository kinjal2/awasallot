<?php

// app/Models/Otp.php
namespace App;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Otp extends Model
{
    use HasFactory;

    protected $table = 'userschema.otps';  // Specify schema if needed

    protected $fillable = [
        'user_id', 
        'mobile_no', 
        'otp', 
        'created_at', 
        'updated_at', 
        'attempts', 
        'blocked_until', 
        'expires_at',
    ];

    // Set the timestamp fields to true
    public $timestamps = true;
    public static function generateOtpForUser($user)
    {
        // Generate a 6-digit OTP
        $otp = rand(100000, 999999);
        $otp=123456;
        // Set the OTP expiration time (e.g., 10 minutes from now)
        $expiresAt = Carbon::now()->addMinutes(10);

        // Create or update the OTP record for the user
        return self::updateOrCreate(
            ['user_id' => $user->id],
            [
                'mobile_no' => $user->contact_no,
                'otp' => $otp,
                'expires_at' => $expiresAt,
                'attempts' => 0, // No failed attempts initially
            ]
        );
    }

    /**
     * Send OTP to the user's mobile number.
     */
    public static function sendOtpToUser($mobileNo, $otp)
    {
        // Logic for sending OTP (you can replace this with your actual SMS service code)
        $message = "Your OTP is: $otp. This OTP will expire in 10 minutes.";

        // Example of sending OTP (replace with your SMS gateway logic)
        // Example: Using curl to send the OTP via an API
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://localhost:8021/send?receiverid=$mobileNo&msg=" . base64_encode($message));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $body = curl_exec($ch);
        curl_close($ch);

        // Log or handle the response as needed
        // Log::info("OTP sent to $mobileNo: $message");
    }

    /**
     * Validate the OTP entered by the user.
     */
    public static function validateOtp($user, $inputOtp)
    {
        // Get the OTP record for the user
        $otp = self::where('user_id', $user->id)->first();

        // Check if OTP exists and is not expired
        if (!$otp || Carbon::now()->greaterThan($otp->expires_at)) {
            return ['error' => 'Invalid or expired OTP.'];
        }

        // Check if OTP is correct
        if ($otp->otp !== $inputOtp) {
            // Increment attempts on failure
            $otp->increment('attempts');

            // Lock account after 3 failed attempts
            if ($otp->attempts >= 3) {
                $otp->blocked_until = Carbon::now()->addMinutes(30); // Lock for 30 minutes
                $otp->save();
                return ['error' => 'Too many failed attempts. Your account is locked for 30 minutes.'];
            }

            return ['error' => 'Incorrect OTP.'];
        }

        // OTP is valid
        return ['success' => 'OTP verified successfully.'];
    }
}
