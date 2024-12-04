<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use App\Repositories\UserRepository;
use Illuminate\Http\RedirectResponse;

class ProfileController extends Controller
{
    public function __construct(
        private readonly UserRepository $r_user
    )
    {}

    // @desc    Update profile info
    // @route   PUT /profile
    public function update(UpdateProfileRequest $request): RedirectResponse
    {
        // Validate data
        $validated = $request->validated();

        // Update user info
        $this->r_user->update(auth()->id(), $validated);

        return redirect()->route('dashboard')->with('success', 'Profile info updated!');
    }
}
