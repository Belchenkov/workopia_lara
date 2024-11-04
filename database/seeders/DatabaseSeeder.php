<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('users')->truncate();
        DB::table('job_listings')->truncate();

        $this->call(RandomUserSeeder::class);
        $this->call(RandomJobSeeder::class);
        $this->call(JobSeeder::class);
    }
}
