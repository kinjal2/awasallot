<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use App\DDOCode;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\District;
use App\Taluka;

class RegisterController extends Controller
{
    use RegistersUsers;

 //   protected $redirectTo = RouteServiceProvider::HOME;
    protected $redirectTo = '/home'; // Or any other path you want to redirect to

    // Or override the redirectPath() method
    protected function redirectPath()
    {
        if (auth()->user()->isAdmin()) {
            return '/admin/dashboard'; // Redirect admins to the admin dashboard
        } else {
            return '/user/dashboard'; // Redirect regular users to the user dashboard
        }
    }

    public function __construct()
    {
        $this->middleware('guest');

    }

    protected function validator(array $data)
    {
        //dd($data);
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'contact_no' => ['required', 'string', 'regex:/^[0-9]{10}$/', 'unique:users,contact_no'],
            'captcha' => ['required', 'captcha'],
            'designation' => 'required|regex:/^[a-zA-Z\s]+$/', // only letters and spaces
            'officename' => 'required|regex:/^[a-zA-Z\s]+$/', // only letters and spaces
            'district' => 'required',
            'taluka' => 'required',
        ], [
            'name.required' => 'The name is required.',
            'name.string' => 'The name must be a string.',
            'name.max' => 'The name may not be greater than 255 characters.',
            'email.required' => 'The email is required.',
            'email.string' => 'The email must be a string.',
            'email.email' => 'The email must be a valid email address.',
            'email.max' => 'The email may not be greater than 255 characters.',
            'email.unique' => 'The email has already been taken.',
            'designation.required' => 'Please enter your designation',
            'designation.regex' => 'Designation should contain only letters and spaces',
            'officename.required' => 'Please enter your office name',
            'officename.regex' => 'Office name should contain only letters and spaces',
            'district.required' => 'Please select your district',
            'taluka.required' => 'Please select your taluka',
             'contact_no.required' => 'The contact number is required.',
            'contact_no.string' => 'The contact number must be a string.',
            'contact_no.regex' => 'The contact number must be a valid 10-digit number.',
            'contact_no.unique' => 'The contact number has already been taken.',
            'captcha.required' => 'The captcha is required.',
            'captcha.captcha' => 'The captcha is invalid.',
        ]);
    }

public function register(Request $request)
{
    $data = $request->all();

    $validator = $this->validator($data);
    //dd($validator);
    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }
   // dd($data);
    $this->create($data);

    return redirect()->route('home')->with('success', 'User registered successfully!');
}

protected function create(array $data)
{
   // dd($data);
    // Format the birthdate to Y-m-d if needed

  // dd(\Session::get('uid'));

    if (!\Session::get('uid')) {
       //\DB::connection()->enableQueryLog();
       $data['birthdate'] = \Carbon\Carbon::createFromFormat('d-m-Y', $data['birthdate'])->format('Y-m-d');
       try {
            // Remove all whitespace from the name and capitalize the first letter
            $name = preg_replace('/\s+/', '', $data['name']);
            $name = ucfirst($name);

            // Generate password based on formatted name and birthdate
            $result = substr($name, 0, 5);
            $result1 = substr($data['birthdate'], 0, 4);
            $password = $result . '@' . $result1;

            // Create a new user with the provided data and generated password
            $user = User::create([
                    'name' => htmlentities(strip_tags($data['name'])),
                    'email' => htmlentities(strip_tags($data['email'])),
                    // 'password' => Hash::make($password), // Hash the generated password
                    'date_of_birth' => htmlentities(strip_tags($data['birthdate'])),
                    'designation' => htmlentities(strip_tags($data['designation'])),
                    'office' => htmlentities(strip_tags($data['officename'])),
                    'contact_no' => htmlentities(strip_tags($data['contact_no'])),
                    //'ddo_no' => htmlentities(strip_tags($data['ddo_no'])),
                    //'cardex_no' => htmlentities(strip_tags($data['cardex_no'])),
                    //'ddo_code' => htmlentities(strip_tags($data['ddo_code'])),
                    'dcode' => htmlentities(strip_tags($data['district'])),
                    'tcode' => htmlentities(strip_tags($data['taluka'])),
            ]);

        return response()->json(['message' => 'User created successfully', 'user' => $user], 201);
    } catch (Exception $e) {
        Log::error('Error creating user: ' . $e->getMessage());

        return response()->json(['error' => 'Error creating user'], 500);
    }



    } else {
        return User::create([
            'is_admin' => 1,
            'usercode' => \Session::get('uid'),
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make('test@123'), // Ideally use the user-provided password
        ]);
    }

}
public function reloadCaptcha()
{
    $captcha = captcha_img();
    return response()->json(['captcha'=> captcha_img()]);
}

 public function getDDOCode(Request $request)
 {

     // Validate the input
     $request->validate([
         'cardex_no' => 'required',
     ]);

     $cardexNo = $request->input('cardex_no');

     // Fetch data from your database based on cardex_no
     $data = DDOCode::select('ddo_code', 'ddo_office')->where('cardex_no', '=', $cardexNo)->get(); // Adjust fields as necessary
     return response()->json($data);
 }
 public function getTalukaByDistrict(Request $request)
{
    $dcode = $request->input('dcode');

    // Validate the input
    if (!$dcode) {
        return response()->json([], 400); // Return empty if dcode is not valid
    }

    // Fetch talukas by district code (assuming you have a Taluka model with a dcode foreign key)
    $talukas = Taluka::where('dcode', $dcode)->get(['tcode', 'name_g', 'name_e']);

    return response()->json($talukas);
}
}
