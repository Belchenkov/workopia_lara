<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class JobController extends Controller
{
    public function index(): View
    {
        $title = 'Available Jobs';
        $jobs = [
            'Software Engineer',
            'Web Developer',
            'Data Scientist',
        ];

        return view('jobs/index', compact('title', 'jobs'));
    }

    public function create()
    {
        return view('jobs/create');
    }
}
