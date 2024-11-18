<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /*
     * @desc Show register form
     * @route GET /register
     */
    public function register()
    {
        return view('auth.register');
    }
}
