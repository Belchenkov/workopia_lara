<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Repositories\JobRepository;
use Illuminate\Http\RedirectResponse;
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

    // @desc    Create new bookmarked job
    // @route   POST /bookmarks/{job}
    public function store(Job $job): RedirectResponse
    {
        $user = auth()->user();

        // Check if the job is already bookmarked
        if ($this->r_job->existsBookmarkedJobsByUser($user, $job->id)) {
            return back()->with('error', 'Job is already bookmarked');
        }

        // Create new bookmark
        $user->bookmarkedJobs()->attach($job->id);

        return back()->with('success', 'Job bookmarked successfully!');
    }

    // @desc    Remove bookmarked job
    // @route   DELETE /bookmarks/{job}
    public function destroy(Job $job): RedirectResponse
    {
        $user = auth()->user();

        // Check if the job is not bookmarked
        if (!$this->r_job->existsBookmarkedJobsByUser(auth()->user(), $job->id)) {
            return back()->with('error', 'Job is not bookmarked');
        }

        // Remove bookmark
        $user->bookmarkedJobs()->detach($job->id);

        return back()->with('success', 'Bookmark removed successfully!');
    }
}
