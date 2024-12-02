<?php

namespace App\Repositories;

use App\Models\Job;
use Illuminate\Database\Eloquent\Collection;

class JobRepository
{
    public function all(): Collection
    {
        return Job::all();
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
}
