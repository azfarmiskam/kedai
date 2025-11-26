<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Rules\ValidCaptcha;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Show the login form
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle login request
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'captcha' => ['required', new ValidCaptcha],
        ]);

        if (Auth::attempt($request->only('email', 'password'), $request->filled('remember'))) {
            $request->session()->regenerate();

            // Role-based redirection
            $user = Auth::user();
            if ($user->hasRole('superadmin')) {
                return redirect()->intended('/superadmin/dashboard')->with('success', 'Welcome back, Super Admin!');
            } elseif ($user->hasRole('admin')) {
                return redirect()->intended('/admin/dashboard')->with('success', 'Welcome back, Admin!');
            } elseif ($user->hasRole('seller')) {
                return redirect()->intended('/seller/dashboard')->with('success', 'Welcome back!');
            } else {
                return redirect()->intended('/buyer/dashboard')->with('success', 'Welcome back!');
            }
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput($request->except('password'));
    }

    /**
     * Handle logout request
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'You have been logged out successfully.');
    }
}
