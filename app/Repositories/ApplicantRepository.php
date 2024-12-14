<?php

namespace App\Repositories;

use App\Models\Applicant;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ApplicantRepository
{
    public function all(): Collection
    {
        return Applicant::all();
    }

    public function paginate(int $per_page = 9): LengthAwarePaginator
    {
        return Applicant::latest()->paginate($per_page);
    }

    public function create(array $data): Applicant
    {
        return Applicant::create($data);
    }

    public function update(int $id, array $data): int
    {
        return Applicant::where('id', $id)->update($data);
    }

    public function delete(int $id): int
    {
        return Applicant::destroy($id);
    }

    public function existsApplicationByUser(int $user_id, int $job_id): bool
    {
        return Applicant::where('job_id', $job_id)
            ->where('user_id', $user_id)
            ->exists();
    }
}
