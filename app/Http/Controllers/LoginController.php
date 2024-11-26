<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
     * @desc Show login form
     * @route GET /login
     */
    public function login()
    {
        return view('auth.login');
    }

    // @desc   Authenticate user
    // @route   POST /login
    public function authenticate(LoginRequest $request): \Illuminate\Http\RedirectResponse
    {
        $credentials = $request->validated();

        // Attempt to authenticate user
        if (Auth::attempt($credentials)) {
            // Regenerate the session to prevent fixation attacks
            $request->session()->regenerate();

            return redirect()->intended(route('home.index'))->with('success', 'You are now logged in!');
        }

        // If auth fails, redirect back with error
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records'
        ])->onlyInput('email');
    }
}
