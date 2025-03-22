<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MedicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('medications')->insert([
            [
                'name' => 'Paracetamol',
                'producer' => 'Medley',
                'type_of_aplication' => 'Intramuscular',
                'price' => 12.50,
                'age_type' => 'Adulto',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Ibuprofeno',
                'producer' => 'Neo Química',
                'type_of_aplication' => 'Intramuscular',
                'price' => 18.90,
                'age_type' => 'Adulto',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Amoxicilina',
                'producer' => 'EMS',
                'type_of_aplication' => 'Intramuscular',
                'price' => 25.00,
                'age_type' => 'Infantil',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Dipirona Sódica',
                'producer' => 'Sanofi',
                'type_of_aplication' => 'Injetável',
                'price' => 8.75,
                'age_type' => 'Adulto',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Omeprazol',
                'producer' => 'Aché',
                'type_of_aplication' => 'Intramuscular',
                'price' => 32.90,
                'age_type' => 'Adulto',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Cetirizina',
                'producer' => 'Eurofarma',
                'type_of_aplication' => 'Intramuscular',
                'price' => 14.60,
                'age_type' => 'Infantil',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Azitromicina',
                'producer' => 'Prati-Donaduzzi',
                'type_of_aplication' => 'Intramuscular',
                'price' => 41.30,
                'age_type' => 'Adulto',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Hidrocortisona',
                'producer' => 'Teuto',
                'type_of_aplication' => 'Intramuscular',
                'price' => 15.90,
                'age_type' => 'Adulto',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Metformina',
                'producer' => 'EMS',
                'type_of_aplication' => 'Intramuscular',
                'price' => 22.45,
                'age_type' => 'Adulto',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Lorazepam',
                'producer' => 'Cristália',
                'type_of_aplication' => 'Intramuscular',
                'price' => 56.80,
                'age_type' => 'Adulto',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
