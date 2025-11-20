<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    /**
     * Show login form
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle login request
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        // Attempt to log in
        if (Auth::attempt($credentials, $request->filled('remember'))) {
            // Regenerate session to prevent fixation
            $request->session()->regenerate();

            return redirect()->intended(route('dashboard'));
        }

        // Login failed
        return back()
            ->withErrors(['email' => 'Invalid email or password.'])
            ->withInput($request->only('email'));
    }

    /**
     * Show forgot password form
     */
    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Send password reset link
     */
    public function sendResetLinkEmail(ForgotPasswordRequest $request)
    {
        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', __($status))
            : back()->withErrors(['email' => __($status)]);
    }

    /**
     * Show reset password form
     */
    public function showResetForm($token)
    {
        return view('auth.reset-password', compact('token'));
    }

    /**
     * Reset password
     */
    public function reset(ResetPasswordRequest $request)
    {
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->password = Hash::make($password);
                $user->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => __($status)]);
    }

    /**
     * Logout user
     */
    public function logout(Request $request)
    {
        Auth::logout(); // Remove user from session

        $request->session()->invalidate(); // Clear session data
        $request->session()->regenerateToken(); // Generate new CSRF token

        // Remove session cookie
        $cookie = Cookie::forget('laravel_session');

        return redirect()->route('login')->withCookie($cookie);
    }

    /**
     * Show dashboard (protected)
     */
    public function dashboard()
    {
        $usersCount     = \App\Models\User::count();
        $schoolsCount   = \App\Models\School::count();
        $countriesCount = \App\Models\Country::count();
        $statesCount    = \App\Models\State::count();

        return view('admin.dashboard', compact(
            'usersCount',
            'schoolsCount',
            'countriesCount',
            'statesCount'
        ));
    }
}
