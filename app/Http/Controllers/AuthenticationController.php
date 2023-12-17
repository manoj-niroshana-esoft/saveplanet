<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use Hash;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\View;
use Log;
use Mail;
use stdClass;
use Str;
use Validator;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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

    public function register_user(Request $request)
    {

        $userDeatils = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'password' => 'required|string|min:8',
            'confirm_password' => 'required|same:password|min:8',
            'address' => 'required',
            'nic' => 'required|unique:users,nic',
            'email' => 'required|email|unique:users,email',
        ]);

        if ($userDeatils->fails()) {
            return redirect('auth-register')->with('error', $userDeatils->errors()->first());
        }
        DB::beginTransaction();
        try {

            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'password' => Hash::make($request->password),
                'address' => $request->address,
                'nic' => $request->nic,
                'email' => $request->email,
            ]);

            /**
             * Start Activation Link
             */
            do {
                $token_id = Str::random(32);
            } while (User::where('verification_token', '=', $token_id)->first() instanceof User);

            // $user = User::find($user->u_id);
            $user->update([
                'verification_token' => $token_id,
            ]);
            // $link = config('app.activation_link') . $token_id;
            // Mail::send(new ActivationLink($link, $user->email, $request->candidate_type == '2' ? $prefixWithNewAdmission : $request->school_admission_no, $request->user_name));
            /**
             * End Activation LInk
             */

            DB::commit();
            return redirect('auth-login')->with('success', 'User Created in successfully!');
        } catch (\Exception $e) {
            DB::rollback();
            Log::critical($e->getMessage());
            return redirect('auth-register')->with('error', $e->getMessage());
        }
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

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->flush();
        $request->session()->invalidate();
        // $request->session()->regenerateToken();
        return redirect('/auth-login');
    }
}
