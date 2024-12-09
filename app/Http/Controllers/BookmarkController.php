<?php

namespace App\Http\Controllers;

use App\Repositories\JobRepository;
use Illuminate\View\View;

class BookmarkController extends Controller
{
    public function __construct(
        private readonly JobRepository $r_job
    )
    {}

    public function index(): View
    {
        return view('jobs.bookmarked')
            ->with('bookmarks', $this->r_job->paginateBookmarks(auth()->user()));
    }
}
