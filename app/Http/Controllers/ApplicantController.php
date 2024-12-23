<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreApplicantRequest;
use App\Mail\JobApplied;
use App\Models\Job;
use App\Repositories\ApplicantRepository;
use App\Services\FileJobServices;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;

class ApplicantController extends Controller
{
    public function __construct(
        private readonly ApplicantRepository $r_applicant,
        private readonly FileJobServices $r_file,
    )
    {}

    // @desc    Store new job application
    // @route   POST /jobs/{job}/apply
    public function store(StoreApplicantRequest $request, Job $job): RedirectResponse
    {
        // Check if the user has already applied
        $existingApplication = $this->r_applicant->existsApplicationByUser($job->id, auth()->id());

        if ($existingApplication) {
            return redirect()->back()->with('error', 'You have already applied to this job');
        }

        // Validate incoming data
        $validatedData = [
            ...$request->validated(),
            'user_id' => auth()->id(),
            'job_id' => $job->id,
        ];

        // Handle resume uplaod
        if ($request->hasFile('resume')) {
            $validatedData['resume_path'] = $this->r_file->uploadFile(
                $request->file('resume'),
                'resumes',
                'public'
            );
        }

        $application = $this->r_applicant->create($validatedData);

         Mail::to($job->user->email)->send(new JobApplied($application, $job));

        return redirect()->back()->with('success', 'Your application has been submitted');
    }

    // @desc    Delete job applicant
    // @route   DELETE /applicants/{applicant}
    public function destroy(int $id): RedirectResponse
    {
        $this->r_applicant->delete($id);

        return redirect()->route('dashboard')->with('success', 'Applicant deleted successfully!');
    }
}
