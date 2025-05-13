<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            prodiSeeder::class,
            alumniSeeder::class,
            instansiSeeder::class,
            profesiSeeder::class,
            penggunaLulusanSeeder::class,
            tracerSeeder::class,
            kepuasanPenggunaSeeder::class,
        ]);
    }
}
