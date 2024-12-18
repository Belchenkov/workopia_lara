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
        return Job::where('user_id', $user_id)
            ->with('applicants')
            ->get();
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

    public function search(?string $keywords, ?string $location, int $paginate = 12): LengthAwarePaginator
    {
        $query = Job::query();

        if ($keywords) {
            $query->where(function ($q) use ($keywords) {
                $q->whereRaw('LOWER(title) like ?', ['%' . $keywords . '%'])
                    ->orWhereRaw('LOWER(description) like ?', ['%' . $keywords . '%'])
                    ->orWhereRaw('LOWER(tags) like ?', ['%' . $keywords . '%']);
            });
        }

        if ($location) {
            $query->where(function ($q) use ($location) {
                $q->whereRaw('LOWER(address) like ?', ['%' . $location . '%'])
                    ->orWhereRaw('LOWER(city) like ?', ['%' . $location . '%'])
                    ->orWhereRaw('LOWER(state) like ?', ['%' . $location . '%'])
                    ->orWhereRaw('LOWER(zipcode) like ?', ['%' . $location . '%']);
            });
        }

        return $query->paginate($paginate);
    }
}
