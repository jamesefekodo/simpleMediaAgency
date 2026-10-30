<?php

namespace App\Http\Controllers;

use App\Mail\Auth\NewAccountWelcomeMail;
use App\Mail\Auth\PasswordResetMail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function redirectToUserDashboard($accountType)
    {
        switch ($accountType) {
            // 0 - admin, 1-staff , 2- customer
            case 0:
            case 1:
                return redirect()->route('adminDashboard');
            case 2:
                return redirect()->route('customerDashboard');
            default:
                return $this->accessDeniedLogout();
        }
    }

    public function AuthLogout()
    {
        // Get current session ID
        $currentSessionId = Session::getId();
        $now = Carbon::now();

        Auth::logout();

        // Invalidate and regenerate the session token
        Session::invalidate();
        Session::regenerateToken();


        // Check if session driver is 'database'
        if (config('session.driver') === 'database') {
            $currentSession = DB::table('sessions')->where('id', $currentSessionId)->first();

            // If the session exists, delete it from the database
            if ($currentSession) {
                DB::table('sessions')->where('id', $currentSession->id)->delete();
            }
        }

        return redirect(url('/'))->with('success', 'Logged Out!');
    }
    public function forgotPassword()
    {
        if (!empty(Auth::check())) {
            return $this->redirectToUserDashboard(Auth::user()->account_type);
        }
        return view('utilities.pages.auth.fogortPassword');
    }
    public function requestPasswordResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email_1',
        ]);

        $user = User::getEmailCheck($request->email);
        if (!empty($user)) {
            $user->remember_token = Str::random(30);
            $user->save();
            Mail::to($user->email_1)->send(new PasswordResetMail($user));

            return redirect()->route('loginPage')->with('success', "Sent!");
        } else {
            return redirect()->back()->with('error', 'No Records Found!');
        }
    }
    public function passwordResetPage($remember_token)
    {
        $user = User::getTokenSingle($remember_token);
        if (!empty($user)) {
            $data['user'] = $user;
            return view('utilities.pages.auth.resetPassword', $data);
        } else {
            abort(404);
        }
    }
    public function submitPasswordResetRequest($token, Request $request)
    {
        $passwordRules = [
            'required',
            'string',
            'min:8', // Minimum of 8 characters
            'regex:/[A-Z]/', // At least 1 uppercase letter
            'regex:/[a-z]/', // At least 1 lowercase letter
            'regex:/[0-9]/', // At least 1 number
            'regex:/[!@#$%^&*(),.?":{}|<>]/', // At least 1 special character
        ];

        // Validate input
        $validator = Validator::make($request->all(), [
            'password' => $passwordRules,
            'password_confirmation' => 'required|string|same:password',
        ]);

        // Check validation results
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator) // Pass all validation errors
                ->withInput(); // Retain user input
        }

        if ($request->password == $request->password_confirmation) {
            $user = User::getTokenSingle($token);
            if (!$user) {
                return redirect()->back()->with('error', 'User record not found!');
            }

            $user->password = Hash::make($request->password);
            $user->remember_token = Str::random(30);
            $user->save();

            return redirect()->route('loginPage')->with('success', 'Done!');
        } else {
            return redirect()->back()->with('error', 'Passwords do not match!');
        }
    }

    public function accessDeniedLogout()
    {
        // Get current session ID
        $currentSessionId = Session::getId();

        Auth::logout();

        // Invalidate and regenerate the session token
        Session::invalidate();
        Session::regenerateToken();


        // Check if session driver is 'database'
        if (config('session.driver') === 'database') {
            $currentSession = DB::table('sessions')->where('id', $currentSessionId)->first();

            // If the session exists, delete it from the database
            if ($currentSession) {
                DB::table('sessions')->where('id', $currentSession->id)->delete();
            }
        }

        return redirect(url('/'))->with('error', 'Access Denied');
    }
    public function login()
    {
        if (Auth::check()) {
            return $this->redirectToUserDashboard(
                Auth::user()->account_type
            );
        }
        return view('utilities.pages.auth.login');
    }
    public function authLogin(Request $request)
    {
        $request->validate([
            'login_id' => 'required',
            'password' => 'required',
        ]);


        if (Auth::attempt(['username' => $request->login_id, 'password' => $request->password]) || Auth::attempt(['email_1' => $request->login_id, 'password' => $request->password],)) {
            $user = Auth::user();

            if ($user) {
                if ($user->require_login_mfa == 1) {
                    return redirect()->route('authenticateLogin');
                } else {
                    return $this->redirectToUserDashboard($user->account_type);
                }
            } else {
                return redirect()->route('AuthLogout');
            }
        } else {
            return redirect()->back()->with('error', "Invalid Credentials");
        }
    }

    public function register()
    {
        if (Auth::check()) {
            return $this->redirectToUserDashboard(
                Auth::user()->account_type
            );
        }

        return view('utilities.pages.auth.register');
    }
    public function submitUserRegistrationRequest(Request $request)
    {
        $passwordRules = [
            'required',
            'string',
            'min:8', // Minimum of 8 characters
            'regex:/[A-Z]/', // At least 1 uppercase letter
            'regex:/[a-z]/', // At least 1 lowercase letter
            'regex:/[0-9]/', // At least 1 number
            'regex:/[!@#$%^&*(),.?":{}|<>]/', // At least 1 special character
        ];

        // Validate input
        $validator = Validator::make($request->all(), [
            'username' => [
                'required',
                'unique:users,username',
                'regex:/^\S*$/u',           // No spaces allowed
                'min:8',                    // Minimum 8 characters
                'not_regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',  // No email format
                'not_regex:/[\x{1F600}-\x{1F64F}\x{1F300}-\x{1F5FF}\x{1F680}-\x{1F6FF}\x{1F700}-\x{1F77F}\x{1F780}-\x{1F7FF}\x{1F800}-\x{1F8FF}\x{1F900}-\x{1F9FF}\x{1FA00}-\x{1FA6F}\x{1FA70}-\x{1FAFF}\x{2600}-\x{26FF}\x{2700}-\x{27BF}\x{2300}-\x{23FF}\x{2B50}]/u',
            ],

            'email' => 'required|email|unique:users,email_1',

            'phone' => 'required|string|unique:users,phone_1',
            'password' => $passwordRules,
            'password_confirmation' => 'required|string|same:password',
        ], [
            // Custom error messages
            'username.required' => 'The username is required.',
            'username.unique' => 'This username is already taken.',
            'username.regex' => 'The username cannot contain spaces.',
            'password.required' => 'The password is required.',
            'password.min' => 'The password must be at least 8 characters long.',
            'password.regex' => 'The password must include at least one uppercase letter, one lowercase letter, one number, and one special character.',
            'password_confirmation.same' => 'The confirmation password does not match.',
        ]);


        // Check validation results
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator) // Pass all validation errors
                ->withInput(); // Retain user input
        }


        $user = new User();
        $user->username = strtolower(trim($request->username));
        $user->phone_1 = trim($request->phone);
        $user->email_1 = trim($request->email);
        $user->account_type = 2;
        $user->password = Hash::make($request->password);
        $user->save();

        Mail::to($user->email_1)->queue(
            new NewAccountWelcomeMail($user)
        );

        $loginRequest = new Request([
            'login_id' => $user->email_1,
            'password' => $request->password,
        ]);

        return $this->authLogin($loginRequest);
    }
}
