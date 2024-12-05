<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use App\Repositories\UserRepository;
use App\Services\FileJobServices;
use Illuminate\Http\RedirectResponse;

class ProfileController extends Controller
{
    public function __construct(
        private readonly UserRepository $r_user,
        private readonly FileJobServices $s_file_job,
    )
    {}

    // @desc    Update profile info
    // @route   PUT /profile
    public function update(UpdateProfileRequest $request): RedirectResponse
    {
        // Validate data
        $validated = $request->validated();
        $user = auth()->user();

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
            if ($user->avatar) {
                $this->s_file_job->deleteFile('public/' . $user->avatar);
            }

            // Store new avatar
            $validated['avatar'] = $this->s_file_job->uploadFile(
                $request->file('avatar'),
                'avatars',
                'public'
            );
        }

        // Update user info
        $this->r_user->update($user->id, $validated);

        return redirect()->route('dashboard')->with('success', 'Profile info updated!');
    }
}
