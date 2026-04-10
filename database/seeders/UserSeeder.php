<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::where('email', 'agency@gmail.com')->delete();

        User::updateOrCreate(
            ['email' => 'datamonitoring123@gmail.com'],
            [
                'name' => 'Master Admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'agency_id' => null,
            ]
        );

        User::updateOrCreate(
            ['email' => 'dict@example.com'],
            [
                'name' => 'DICT Admin',
                'password' => Hash::make('password'),
                'role' => 'agency',
                'agency_id' => 1,
            ]
        );

        User::updateOrCreate(
            ['email' => 'doh@example.com'],
            [
                'name' => 'DOH Admin',
                'password' => Hash::make('password'),
                'role' => 'agency',
                'agency_id' => 2,
            ]
        );

        User::updateOrCreate(
            ['email' => 'dpwh@example.com'],
            [
                'name' => 'DPWH Admin',
                'password' => Hash::make('password'),
                'role' => 'agency',
                'agency_id' => 3,
            ]
        );
    }
}
