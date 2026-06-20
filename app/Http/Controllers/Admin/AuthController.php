<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function login()
    {
        return check_admin_auth('backend.auth.login');
    }
    public function login_submit(Request $request)
    {
        $request->validate([
            'email_username' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('email_username', 'password');
        if (filter_var($credentials['email_username'], FILTER_VALIDATE_EMAIL)) {
            $authAttempt = Auth::guard('admin')->attempt(['email' => $credentials['email_username'], 'password' => $credentials['password'], 'status' => '1']);
        } else {
            $authAttempt = Auth::guard('admin')->attempt(['username' => $credentials['email_username'], 'password' => $credentials['password'],  'status' => '1']);
        }
        if ($authAttempt && Auth::guard('admin')->user()->status != 'blocked') {
            toastr()->success('Admin Login successfully.');

            return redirect()->intended(route('admin.dashboard'));
        }
        toastr()->error('Invalid credentials or account is blocked.');

        return redirect()->back();
    }
    public function logout()
    {
        auth()->guard('admin')->logout();
        toastr()->success(' Admin Logout Successfully');

        return redirect()->route('admin.login');
    }

    public function forgetpass()
    {
        return check_admin_auth('backend.auth.forget_password');
    }
    public function submitforgetpass(request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $emailExists = DB::table('admins')
            ->where('email', $request->email)
            ->exists();

        if (!$emailExists) {
            toastr()->error('The provided email was not found.');

            return redirect()->back();
        }
        $existingToken = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        if ($existingToken) {
            toastr()->info('Email already has been sent successfully!');
            return redirect()->back();
        }

        $token = Str::random(64);
        DB::table('password_reset_tokens')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);

        Mail::send('backend.emails.forget_password', ['token' => $token], function ($message) use ($request) {
            $message->to($request->email);
            $message->subject('Reset Password');
        });

        toastr()->success(' We have E-mailed yours password reset link!');

        return redirect()->back();
    }
    public function show_reset_pass_form($token)
    {
        $updatePassword = DB::table('password_reset_tokens')
            ->where('token', $token)
            ->first();

        if (!$updatePassword) {
            toastr()->error(' Token has expired or is invalid');

            return redirect()->route('admin.login');
        }
        return view('backend.auth.reset_password', ['token' => $token]);
    }
    public function submit_reset_pass_form(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:admins',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required'
        ]);

        $updatePassword = DB::table('password_reset_tokens')
            ->where([
                'email' => $request->email,
                'token' => $request->token
            ])->first();

        if (!$updatePassword) {
            toastr()->error(' Token has expired or is invalid');
            return redirect()->route('admin.login');
        }

        $newPassword = $request->password;
        Admin::where('email', $request->email)->update(['password' => Hash::make($newPassword)]);
        DB::table('password_reset_tokens')->where(['email' => $request->email])->delete();

        toastr()->success(' Your password has been successfully updated.');

        return redirect()->route('admin.login');
    }
}
