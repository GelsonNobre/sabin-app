<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MedicationSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('medications')->insert([
            [
                'name'               => 'Diazepam',
                'producer'           => 'Cristália',
                'type_of_aplication' => 'IM',
                'price'              => 12.50,
                'age_type'           => 'adulto',
                'created_at'         => now(),
                'updated_at'         => now(),
            ],
            [
                'name'               => 'Dipirona Sódica',
                'producer'           => 'Sanofi',
                'type_of_aplication' => 'IM',
                'price'              => 18.90,
                'age_type'           => 'adulto',
                'created_at'         => now(),
                'updated_at'         => now(),
            ],
            [
                'name'               => 'Ceftriaxona',
                'producer'           => 'Aché',
                'type_of_aplication' => 'IM',
                'price'              => 25.00,
                'age_type'           => 'infantil',
                'created_at'         => now(),
                'updated_at'         => now(),
            ],
            [
                'name'               => 'Hidrocortisona',
                'producer'           => 'Teuto',
                'type_of_aplication' => 'SC',
                'price'              => 8.75,
                'age_type'           => 'adulto',
                'created_at'         => now(),
                'updated_at'         => now(),
            ],
            [
                'name'               => 'Ampicilina',
                'producer'           => 'Prati-Donaduzzi',
                'type_of_aplication' => 'IM',
                'price'              => 32.90,
                'age_type'           => 'adulto',
                'created_at'         => now(),
                'updated_at'         => now(),
            ],
            [
                'name'               => 'Cetirizina',
                'producer'           => 'Eurofarma',
                'type_of_aplication' => 'IM',
                'price'              => 14.60,
                'age_type'           => 'infantil',
                'created_at'         => now(),
                'updated_at'         => now(),
            ],
            [
                'name'               => 'Tramadol',
                'producer'           => 'Eurofarma',
                'type_of_aplication' => 'IM',
                'price'              => 41.30,
                'age_type'           => 'adulto',
                'created_at'         => now(),
                'updated_at'         => now(),
            ],
            [
                'name'               => 'Hidrocortisona',
                'producer'           => 'Teuto',
                'type_of_aplication' => 'IM',
                'price'              => 15.90,
                'age_type'           => 'adulto',
                'created_at'         => now(),
                'updated_at'         => now(),
            ],
            [
                'name'               => 'Ondansetrona',
                'producer'           => 'EMS',
                'type_of_aplication' => 'IM',
                'price'              => 22.45,
                'age_type'           => 'adulto',
                'created_at'         => now(),
                'updated_at'         => now(),
            ],
            [
                'name'               => 'Nebido',
                'producer'           => 'Bayer',
                'type_of_aplication' => 'IM',
                'price'              => 56.80,
                'age_type'           => 'adulto',
                'created_at'         => now(),
                'updated_at'         => now(),
            ],
        ]);
    }
}
