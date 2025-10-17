<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Cookie;



class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        $user = \App\Models\User::where('email', $credentials['email'])->first();

        // Check if email exists
        if (!$user) {
            return back()
                ->withErrors(['email' => 'This email ID does not exist.'])
                ->withInput($request->only('email'));
        }

        // Check if password matches
        if (!\Illuminate\Support\Facades\Hash::check($credentials['password'], $user->password)) {
            return back()
                ->withErrors(['password' => 'Your password is incorrect. Please try again.'])
                ->withInput($request->only('email'));
        }

        // Attempt login (if all ok)
        if (\Illuminate\Support\Facades\Auth::attempt($credentials)) {
            return redirect()->intended(route('dashboard'));
        }

        // Fallback
        return back()->withErrors(['credential' => 'Invalid credentials.'])->withInput($request->only('email'));
    }


    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLinkEmail(ForgotPasswordRequest $request)
    {
        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', __($status))
            : back()->withErrors(['email' => __($status)]);
    }

    public function showResetForm($token)
    {
        return view('auth.reset-password')->with(['token' => $token]);
    }

    public function reset(ResetPasswordRequest $request)
    {
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->update(['password' => bcrypt($password)]);
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => __($status)]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate(); // Invalidate old session
        $request->session()->regenerateToken(); // Prevent CSRF reuse

        // Remove Laravel session cookie explicitly
        $cookie = Cookie::forget('laravel_session');

        return redirect()->route('login')->withCookie($cookie);
    }

    public function dashboard()
    {
        return view('admin.dashboard');
    }
}
