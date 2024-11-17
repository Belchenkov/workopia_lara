<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateJobRequest;
use App\Http\Requests\UpdateJobRequest;
use App\Models\Job;
use App\Repositories\JobRepository;
use App\Services\FileJobServices;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class JobController extends Controller
{
    public function __construct(
        private readonly JobRepository $r_job,
        private readonly FileJobServices $s_file_job,
    )
    {}

    public function index(): View
    {
        $title = 'Available Jobs';
        $jobs = $this->r_job->all();

        return view('jobs/index', compact('title', 'jobs'));
    }

    public function create(): View
    {
        return view('jobs/create');
    }

    public function show(Job $job): View
    {
        return view('jobs.show', compact('job'));
    }

    public function edit(Job $job): View
    {
        return view('jobs.edit')->with('job', $job);
    }

    public function store(CreateJobRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        if ($request->hasFile('company_logo')) {
            $validated['company_logo'] = $this->s_file_job->uploadFile($request->file('company_logo'));
        }

        $this->r_job->create($validated);

        return redirect()
            ->route('jobs.index')
            ->with('success', 'Job listing created successfully!');
    }

    public function update(UpdateJobRequest $request, Job $job): string
    {
        $validated = $request->validated();

        if ($request->hasFile('company_logo')) {
            $validated['company_logo'] = $this->s_file_job->reUploadFile(
                $request->file('company_logo'),
                $job->company_logo
            );
        }

        $this->r_job->update($job->id, $validated);

        return redirect()
            ->route('jobs.index')
            ->with('success', 'Job listing updated successfully!');
    }

    public function destroy(Job $job): RedirectResponse
    {
        // If logo, then delete it
        if ($job->company_logo) {
            $this->s_file_job->deleteFile('public/logos/' . $job->company_logo);
        }

        $this->r_job->delete($job->id);

        return redirect()->route('jobs.index')->with('success', 'Job listing deleted successfully!');
    }
}
