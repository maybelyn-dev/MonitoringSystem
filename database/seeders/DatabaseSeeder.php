<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'System Admin',
            'email' => 'datamonitoring123@gmail.com',
            'role' => 'admin',
            'password' => Hash::make('password'),
        ]);

        User::factory()->create([
            'name' => 'DICT Focal',
            'email' => 'dict.focal@example.com',
            'role' => 'focal',
            'agency_name' => 'DICT',
            'password' => Hash::make('password'),
        ]);

        User::factory()->create([
            'name' => 'PSA Viewer',
            'email' => 'psa.viewer@example.com',
            'role' => 'focal_viewer',
            'password' => Hash::make('password'),
        ]);
    }
}
