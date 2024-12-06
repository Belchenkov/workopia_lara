<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateJobRequest;
use App\Http\Requests\UpdateJobRequest;
use App\Models\Job;
use App\Repositories\JobRepository;
use App\Services\FileJobServices;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class JobController extends Controller
{
    use AuthorizesRequests;

    public function __construct(
        private readonly JobRepository $r_job,
        private readonly FileJobServices $s_file_job,
    )
    {}

    // @desc    Show all job listings
    // @route   GET /jobs
    public function index(): View
    {
        $title = 'Available Jobs';
        $jobs = $this->r_job->paginate();

        return view('jobs/index', compact('title', 'jobs'));
    }

    // @desc    Show create job form
    // @route   GET /jobs/create
    public function create(): View
    {
        return view('jobs.create');
    }

    // @desc    Display a single job listing
    // @route   GET /jobs/{$id}
    public function show(Job $job): View
    {
        return view('jobs.show', compact('job'));
    }

    // @desc    Show edit job form
    // @route   GET /jobs/{$id}/edit
    public function edit(Job $job): View
    {
        // Check if user is authorized
        $this->authorize('update', $job);

        return view('jobs.edit')->with('job', $job);
    }

    // @desc    Save job to database
    // @route   POST /jobs
    public function store(CreateJobRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        if ($request->hasFile('company_logo')) {
            $validated['company_logo'] = $this->s_file_job->uploadFile(
                $request->file('company_logo'),
                'logos',
                'public'
            );
        }

        $this->r_job->create($validated);

        return redirect()
            ->route('jobs.index')
            ->with('success', 'Job listing created successfully!');
    }

    // @desc    Update job listing
    // @route   PUT /jobs/{$id}
    public function update(UpdateJobRequest $request, Job $job): string
    {
        // Check if user is authorized
        $this->authorize('update', $job);

        $validated = $request->validated();

        if ($request->hasFile('company_logo')) {
            $validated['company_logo'] = $this->s_file_job->reUploadFile(
                $request->file('company_logo'),
                'public/logos/' . basename($job->company_logo),
                'logos',
                'public'
            );
        }

        $this->r_job->update($job->id, $validated);

        return redirect()
            ->route('jobs.index')
            ->with('success', 'Job listing updated successfully!');
    }

    // @desc    Delete a job listing
    // @route   DELETE /jobs/{$id}
    public function destroy(Job $job): RedirectResponse
    {
        // Check if user is authorized
        $this->authorize('delete', $job);

        // If logo, then delete it
        if ($job->company_logo) {
            $this->s_file_job->deleteFile('public/logos/' . $job->company_logo);
        }

        $this->r_job->delete($job->id);

        $route_redirect = 'jobs.index';

        // Check if request came from the dashboard
        if (request()->query('from') === 'dashboard') {
            $route_redirect = 'dashboard';
        }

        return redirect()->route($route_redirect)->with('success', 'Job listing deleted successfully!');
    }
}
