<?php

namespace App\Http\Controllers;

use App\Repositories\JobRepository;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct(
        private readonly JobRepository $r_job
    )
    {}

    // @desc    Show all users job listings
    // @route   GET /dashboard
    public function index(): View
    {
        return view('dashboard.index', [
            'user' => auth()->user(),
            'jobs' => $this->r_job->getByUserWith(auth()->id())
        ]);
    }
}
