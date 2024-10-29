<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Repositories\JobRepository;
use Illuminate\Http\Request;
use Illuminate\View\View;

class JobController extends Controller
{
    public function __construct(
        private JobRepository $r_job,
    )
    {}

    public function index(): View
    {
        $title = 'Available Jobs';
        $jobs = $this->r_job->all();

        return view('jobs/index', compact('title', 'jobs'));
    }

    public function create()
    {
        return view('jobs/create');
    }

    public function show(Job $job): View
    {
        return view('jobs.show', compact('job'));
    }

    public function store(Request $request)
    {
        dd($request->all());
    }
}
