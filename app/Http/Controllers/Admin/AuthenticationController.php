<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\HandleAdminLogin;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\SendResetLinkRequest;
use App\Mail\AdminPasswordResetmailSendLink;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthenticationController extends Controller
{
    public function login()
    {
        return view('admin.auth.login');
    }

    public function handleLogin(HandleAdminLogin $request)
    {
        $request->authenticate();

        if (getRole() == 'Officer') {
            return redirect()->route('admin.activity.index');
        }
        return redirect()->route('admin.dashboard');
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }

    public function ForgotPassword()
    {
        return view('admin.auth.forgot-password');
    }

    public function sendRestLink(SendResetLinkRequest $request)
    {
        $token = Str::random(70);
        $admin = Admin::where('email', $request->email)->first();
        $admin->remember_token = $token;
        $admin->save();

        Mail::to($request->email)->send(new AdminPasswordResetmailSendLink($token, $request->email));

        return redirect()->back()->with('success', 'A mail has been sent to your mail please check!!');
    }

    public function ResetPassword($token)
    {
        return view('admin.auth.reset-password', compact('token'));
    }

    public function HandleResetPassword(ResetPasswordRequest $request)
    {
        $admin = Admin::where(['email' => $request->email, 'remember_token' => $request->token])->first();

        if (!$admin) {
            return back()->with('error', __('backend.Token is invalid'));
        }

        $admin->password = bcrypt($request->password);
        $admin->remember_token = null;
        $admin->save();

        return redirect()->route('admin.login')->with('success', 'Password reset successfull');
    }
}
