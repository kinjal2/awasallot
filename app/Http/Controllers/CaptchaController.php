<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CaptchaController extends Controller
{
    public function reloadCaptcha()
    {
        $captcha = captcha_img();
        return response()->json(['captcha'=> captcha_img()]);
    }
}
