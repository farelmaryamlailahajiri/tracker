<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admins = [
            [
                'username' => 'admin1',
                'nama_lengkap' => 'Farel Maryam Laila H.',
                'email' => 'admin1@example.com',
                'password' => Hash::make('admin1'), // Ganti password sesuai kebutuhan
            ],
            [
                'username' => 'admin2',
                'nama_lengkap' => 'Dwi Septa Satria Agung',
                'email' => 'admin2@example.com',
                'password' => Hash::make('admin2'), // Ganti password sesuai kebutuhan
            ]
        ];

        foreach ($admins as $admin) {
            DB::table('admins')->updateOrInsert(
                ['username' => $admin['username']], // Unik berdasarkan username
                [
                    'nama_lengkap' => $admin['nama_lengkap'],
                    'email' => $admin['email'],
                    'password' => $admin['password'],
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }

        echo "✅ Seeder admin berhasil dijalankan tanpa duplikasi.\n";
    }
}
