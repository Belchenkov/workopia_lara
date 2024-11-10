<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateJobRequest;
use App\Models\Job;
use App\Repositories\JobRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class JobController extends Controller
{
    public function __construct(
        private readonly JobRepository $r_job,
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

        $this->r_job->create($validated);

        return redirect()
            ->route('jobs.index')
            ->with('success', 'Job listing created successfully!');
    }
}
