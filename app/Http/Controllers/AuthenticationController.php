<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends Controller
{
    // Login
    public function login()
    {
        $pageConfigs = [
            'bodyClass' => "bg-full-screen-image",
            'blankPage' => true
        ];

        return view('/pages/auth-login', [
            'pageConfigs' => $pageConfigs
        ]);
    }

    public function check_login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('dashboard-analytics');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    // Register
    public function register()
    {
        $pageConfigs = [
            'bodyClass' => "bg-full-screen-image",
            'blankPage' => true
        ];

        return view('/pages/auth-register', [
            'pageConfigs' => $pageConfigs
        ]);
    }

    // Forgot Password
    public function forgot_password()
    {
        $pageConfigs = [
            'bodyClass' => "bg-full-screen-image",
            'blankPage' => true
        ];

        return view('/pages/auth-forgot-password', [
            'pageConfigs' => $pageConfigs
        ]);
    }

    // Reset Password
    public function reset_password()
    {
        $pageConfigs = [
            'bodyClass' => "bg-full-screen-image",
            'blankPage' => true
        ];

        return view('/pages/auth-reset-password', [
            'pageConfigs' => $pageConfigs
        ]);
    }

    // Lock Screen
    public function lock_screen()
    {
        $pageConfigs = [
            'bodyClass' => "bg-full-screen-image",
            'blankPage' => true
        ];

        return view('/pages/auth-lock-screen', [
            'pageConfigs' => $pageConfigs
        ]);
    }

    public function authenticate(Request $request)
    {
        $userCredentials = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($userCredentials->fails()) {
            return response()->json([
                'error' => true,
                "message" => $userCredentials->errors()->first(),
            ]);
        }
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $request->session()->put('u_id', Auth::user()->u_id);
            $request->session()->put('first_name', Auth::user()->first_name);
            $request->session()->put('last_name', Auth::user()->last_name);
            $request->session()->put('address', Auth::user()->address);
            $request->session()->put('nic', Auth::user()->nic);
            $request->session()->put('email', Auth::user()->email);
            $request->session()->put('auth_user', 1);
            $user = Auth::check();
            // dd($user);
            return redirect()->intended('dashboard-analytics');
        } else {
            return redirect('auth-login')->with('error', 'Invalid Credentials!');
        }
    }
}
