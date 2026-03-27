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

        $admin = User::firstOrCreate(
            ['email' => 'datamonitoring123@gmail.com'],
            [
                'name' => 'Master Admin',
                'password' => Hash::make('password'),
            ]
        );
        $admin->forceFill([
            'role' => 'admin',
            'agency_id' => null,
        ])->save();

        User::firstOrCreate(
            ['email' => 'dict@example.com'],
            [
                'name' => 'DICT Admin',
                'password' => Hash::make('dictadmin123'),
                'role' => 'agency',
                'agency_id' => 1,
            ]
        );

        User::firstOrCreate(
            ['email' => 'doh@example.com'],
            [
                'name' => 'DOH Admin',
                'password' => Hash::make('dohadmin123'),
                'role' => 'agency',
                'agency_id' => 2,
            ]
        );

        User::firstOrCreate(
            ['email' => 'dpwh@example.com'],
            [
                'name' => 'DPWH Admin',
                'password' => Hash::make('dpwhadmin123'),
                'role' => 'agency',
                'agency_id' => 3,
            ]
        );
    }
}
