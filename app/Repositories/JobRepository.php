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

    public function getLatestLimit(int $limit): Collection
    {
        return Job::latest()->limit($limit)->get();
    }
}
