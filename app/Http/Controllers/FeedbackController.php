<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Feedback;

class FeedbackController extends Controller
{
    //
    public function store(Request $request)
    {
        // // Simple CAPTCHA check (1 + 1)
        // if ($request->captcha != 2) {
        //     return back()->withErrors(['captcha' => 'Incorrect captcha answer.'])->withInput();
        // }

        $messages = [
                'name.required' => 'Please enter your name.',
                'name.string' => 'Name must be a valid string.',
                'name.max' => 'Name cannot exceed 255 characters.',
                'name.regex' => 'Name can only contain letters and spaces.',

                'email.required' => 'Please enter your email address.',
                'email.email' => 'Please enter a valid email address.',
                'email.max' => 'Email cannot exceed 255 characters.',

                'phone.required' => 'Please enter your mobile number.',
                'phone.digits' => 'Mobile number must be exactly 10 digits.',

                'captcha.required' => 'Please answer the captcha question.',
                'captcha.captcha' => 'Captcha answer is incorrect.',

                'message.required' => 'Please enter your message.',
                'message.string' => 'Message must be a valid string.',
                'message.max' => 'Message cannot be more than 500 characters.',
                'message.regex' => 'Message contains invalid characters. Allowed: letters, numbers, spaces, &, :, \', ", comma, dot, hyphen.',
            ];


        // Validate the form
       $request->validate([
            'name' => ['required', 'string', 'max:255', 'regex:/^[A-Za-z\s]+$/'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'digits:10'], // exactly 10 digits
            'captcha' => ['required' , 'captcha'],
            'message' => [
                'required',
                'string',
                'max:500',
                'regex:/^[A-Za-z0-9 &,:\'\"\.\-\n\r]+$/'
            ]
        ], $messages);

        // Save to database
        Feedback::create([
            'name' => $request->name,
            'email' => $request->email,
            'contact_no' => $request->phone,
            'message' => $request->message,
        ]);

        return back()->with('success', 'Thank you for your feedback!');
    }
}
