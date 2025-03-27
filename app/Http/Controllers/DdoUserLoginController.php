<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\DDOCode;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class DdoUserLoginController extends Controller {

    // Method to show the login form

    public function showLoginForm() {

        $this->_viewContent[ 'page_title' ] = 'DDO Login';
        return view( 'ddo.ddoLogin', $this->_viewContent );
    }
    // Method for logging in a user

    public function login( Request $request ) {
        // Validate the request
        try {
            // Validate the mobile number or email and captcha
            $request->validate( [
                'ddo_reg_no' => [
                    'required',
                    'regex:/^SGV\d{6}[A-Z]$/', // Regex for DDO Registration Number format
                ],
                'password' => 'required',
                'captcha' => 'required|captcha', // Validate the CAPTCHA
            ],[
                'ddo_reg_no.required' => 'The DDO Registration Number is required.',
                'ddo_reg_no.regex' => 'The DDO Registration Number must be in the format SGV followed by 6 digits and an uppercase letter.',
                'password.required' => 'The password is required.',
                'captcha.required' => 'The CAPTCHA is required.',
                'captcha.captcha' => 'The CAPTCHA is incorrect. Please try again.',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Log the validation errors

            Log::error('Validation errors occurred: ', $e->errors());

            // Optionally, return the error messages to the user
            return back()->withErrors($e->errors());
        }
       
       // dd($request->all());
        // Attempt to log the user in
        if ( Auth::guard( 'ddo_users' )->attempt( $request->only( 'ddo_reg_no', 'password' ) ) ) {
            //dd("success");
            $user = Auth::guard( 'ddo_users' )->user();
            // Store the role and ddo_reg_no in the session
            session( [ 'role' => 'ddouser' ] );
            session( [ 'ddo_reg_no' => $user->ddo_reg_no ] );
            // Store the ddo_reg_no
            session( [ 'cardex_no' => $user->cardex_no ] );
            // Store the cardex_no
            session( [ 'ddo_code' => $user->ddo_code ] );
            // Store the ddo_code
            session( [ 'officecode' => $user->officecode ] );
            //dd( session( 'officecode' ) );
            $ddo_office_email_id = $user->ddo_office_email_id;
            if ( $ddo_office_email_id == null ) {
                return redirect()->route( 'ddo.set_office_email_pwd' )->with( 'message', 'Logged in successfully' );
            } else {
                return redirect()->route( 'ddo.dashboard' )->with( 'message', 'Logged in successfully' );
            }
            return redirect()->route( 'ddo.dashboard' )->with( 'message', 'Logged in successfully' );
        }
        else {
           // dd("Fail");
        return redirect()->back()->withErrors( [ 'ddo_reg_no' => 'Invalid credentials' ] )->withInput();
        }
    }
    // Method for logging out a user

    public function logout() {
        Auth::guard( 'ddo_users' )->logout();
        return response()->json( [ 'message' => 'Logged out successfully' ] );
    }

    public function showOfficeEmailPwdForm() {
        $this->_viewContent[ 'page_title' ] = 'DDO Email and Password Set';
        return view( 'ddo.ddoEmailPwd', $this->_viewContent );
    }

    public function saveEmailPwd( Request $request ) {
        //dd( 'save' );
        //dd( $request->ddo_office_email );
        //dd( $request->password );

        //dd( $user->id );
        $user = Auth::guard( 'ddo_users' )->user();
        // Validate the incoming request
        $request->validate( [
            'ddo_office_email' => 'required|email|regex:/^[a-zA-Z0-9._%+-]+@gujarat\.gov\.in$/|unique:App\DDOCode,ddo_office_email_id,' . $user->id, // Email validation and ensuring uniqueness excluding the current user's email
            // 'ddo_office_email' => [
            //     'required',
            //     'email',
            //     // Check uniqueness using the DDOCode model and exclude the current user's ID
            //     Rule::unique( ( new DDOCode )->getTable(), 'ddo_office_email_id' )->ignore( $user->id ),
            // ],
            'password' => 'required|min:8|confirmed', // Password must be at least 8 characters and must match the 'password_confirmation' field
        ] ,['ddo_office_email.regex' => 'Invalid email. Email must end with @gujarat.gov.in.']);

        try {

            // Update the user's email and password
            $user->ddo_office_email_id = $request->input('ddo_office_email');

            // Only update the password if it's provided
            if ( $request->has( 'password' ) && $request->password != '' ) {
                $user->password = Hash::make( $request->input( 'password' ) );
                //$user->password = $request->input( 'password' );
            }

            // Save the changes to the database
            $user->save();
            return redirect()->route( 'ddo.dashboard' )->with( 'message', 'Logged in successfully' );
        } catch ( Exception $e ) {
            echo $e->getMessage();
        }
    }
}
