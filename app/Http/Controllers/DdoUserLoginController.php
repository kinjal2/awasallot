<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\DDOCode;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Validator;

class DdoUserLoginController extends Controller {

    // Method to show the login form

    public function showLoginForm() {

        $this->_viewContent[ 'page_title' ] = 'DDO Login';
        return view( 'ddo.ddoLogin', $this->_viewContent );
    }
    // Method for logging in a user

    public function login(Request $request)
{
    try {
		 // Decode base64 first
		$decodedPassword = base64_decode($request->password);
		$decodedDdoRegNo = base64_decode($request->ddo_reg_no);

		// Validate CSRF token integrity
		if (
			!str_ends_with($decodedPassword, $request->_token) ||
			!str_ends_with($decodedDdoRegNo, $request->_token)
		) {
			return back()->withErrors(['login' => 'Decryption failed!']);
		}

		// Extract actual values
		$password = str_replace($request->_token, '', $decodedPassword);
		$ddoRegNo = str_replace($request->_token, '', $decodedDdoRegNo);
		
        // Validate input
        // Now validate the decoded inputs
		$validator = Validator::make([
			'ddo_reg_no' => $ddoRegNo,
			'password'   => $password,
			'captcha'    => $request->captcha
		], [
			'ddo_reg_no' => ['required', 'regex:/^SGV\d{6}[A-Z]$/'],
			'password'   => ['required'],
			'captcha'    => ['required', 'captcha'],
		], [
			'ddo_reg_no.required' => 'The DDO Registration Number is required.',
			'ddo_reg_no.regex' => 'The DDO Registration Number must be in the format SGV followed by 6 digits and an uppercase letter.',
			'password.required' => 'The password is required.',
			'captcha.required' => 'The CAPTCHA is required.',
			'captcha.captcha' => 'The CAPTCHA is incorrect. Please try again.',
		]);
		  if ($validator->fails()) {
        throw new \Illuminate\Validation\ValidationException($validator);
    }


    } catch (\Illuminate\Validation\ValidationException $e) {
        // Log::error('Validation errors occurred: ', $e->errors());
        return back()->withErrors($e->errors());
    }

		// Attempt login with decoded password
       if (Auth::guard('ddo_users')->attempt([
        'ddo_reg_no' => $ddoRegNo,
        'password'   => $password
    ])){
        $user = Auth::guard('ddo_users')->user();

        // Store user session data
        session([
            'role'       => 'ddouser',
            'ddo_reg_no' => $user->ddo_reg_no,
            'cardex_no'  => $user->cardex_no,
            'ddo_code'   => $user->ddo_code,
            'officecode' => $user->officecode,
            'dcode' => $user->dcode
        ]);

        // Redirect based on email condition
        return redirect()->route($user->ddo_office_email_id ? 'ddo.dashboard' : 'ddo.set_office_email_pwd')
            ->with('message', 'Logged in successfully');
    }

    // Log failed login attempt (Optional)
    // Log::warning("Failed login attempt for DDO Reg No: " . $request->ddo_reg_no);

    return back()
        ->withErrors(['ddo_reg_no' => 'Invalid credentials'])
        ->withInput();
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
