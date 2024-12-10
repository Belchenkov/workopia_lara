<?php

namespace App\Repositories;

use App\Models\Job;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class JobRepository
{
    public function all(): Collection
    {
        return Job::all();
    }

    public function paginate(int $per_page = 9): LengthAwarePaginator
    {
        return Job::latest()->paginate($per_page);
    }

    public function create(array $data): Job
    {
        return Job::create($data);
    }

    public function update(int $id, array $data): int
    {
        return Job::where('id', $id)->update($data);
    }

    public function getLatestLimit(int $limit): Collection
    {
        return Job::latest()->limit($limit)->get();
    }

    public function delete(int $id): int
    {
        return Job::destroy($id);
    }

    public function getByUserWith(int $user_id): Collection
    {
        return Job::where('user_id', $user_id)->get();
    }

    public function paginateBookmarks(User $user, int $paginate = 9): LengthAwarePaginator
    {
        return $user->bookmarkedJobs()
            ->orderBy('job_user_bookmarks.created_at', 'desc')
            ->paginate($paginate);
    }

    public function existsBookmarkedJobsByUser(User $user, int $job_id): bool
    {
        return $user->bookmarkedJobs()->where('job_id', $job_id)->exists();
    }
}
