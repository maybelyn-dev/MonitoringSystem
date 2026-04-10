<?php

namespace Database\Seeders;

use App\Models\Agency;
use Illuminate\Database\Seeder;

class AgencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $agencies = [
            [
                'agency_name' => 'DICT Region III',
                'province' => 'Bulacan',
                'address' => '123 Government Ave, Malolos, Bulacan',
                'contact' => '(044) 123-4567',
            ],
            [
                'agency_name' => 'DOH Region III',
                'province' => 'Nueva Ecija',
                'address' => '456 Health St, Cabanatuan, Nueva Ecija',
                'contact' => '(044) 234-5678',
            ],
            [
                'agency_name' => 'DPWH Region III',
                'province' => 'Pampanga',
                'address' => '789 Infrastructure Blvd, San Fernando, Pampanga',
                'contact' => '(045) 345-6789',
            ],
            [
                'agency_name' => 'DOST Region III',
                'province' => 'Batangas',
                'address' => '321 Science Park, Batangas City, Batangas',
                'contact' => '(043) 456-7890',
            ],
            [
                'agency_name' => 'DepEd Region III',
                'province' => 'Laguna',
                'address' => '654 Education Center, Santa Rosa, Laguna',
                'contact' => '(049) 567-8901',
            ],
        ];

        foreach ($agencies as $agency) {
            Agency::updateOrCreate(
                ['agency_name' => $agency['agency_name']],
                [
                    'province' => $agency['province'],
                    'address' => $agency['address'],
                    'contact' => $agency['contact'],
                ]
            );
        }
    }
}
