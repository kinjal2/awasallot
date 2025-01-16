<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
class PhoneVerificationController extends Controller
{
    /**
     * Send OTP to the user's phone number after email verification.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request)
    {
        //return view('auth.otp-verification');
        User::callToVerify();
	   return $request->user()->hasVerifiedPhone()
                        ? redirect()->route('home')
                        : view('auth.otp-verification');
    }

    public function verify(Request $request)
    {
       //$request->user()->otp;
       //dd($request->otpnumber);
	   if ($request->user()->otp !== $request->otpnumber) {
            return Redirect::back()->withErrors([
                'code' => ['The code your provided is wrong. Please try again or request another call.'],
            ]);
        }

        if ($request->user()->hasVerifiedPhone()) {
            return redirect()->route('home');
        }

        $request->user()->phoneVerifiedAt();

        return redirect()->route('home')->with('status', 'Your phone was successfully verified!');
    }
}
