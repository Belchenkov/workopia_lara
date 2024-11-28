<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function __construct(
        private readonly UserRepository $r_user
    )
    {}

    /*
     * @desc Show register form
     * @route GET /register
     */
    public function register()
    {
        return view('auth.register');
    }

    public function store(RegisterRequest $request): \Illuminate\Http\RedirectResponse
    {
        $validated = $request->validated();
        $validated['password'] = Hash::make($validated['password']);

        $this->r_user->create($validated);

        return redirect()
            ->route('login')
            ->with('success', 'You are registered and can log in!');
    }
}
