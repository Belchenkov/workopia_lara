<?php

namespace App\Http\Controllers;

use App\Repositories\JobRepository;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct(
        private readonly JobRepository $r_job,
    )
    {}

    public function index()
    {
        $jobs = $this->r_job->getLatestLimit(6);

        return view('pages.index', compact('jobs'));
    }
}
