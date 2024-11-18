<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
}
