<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateJobRequest;
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
}
