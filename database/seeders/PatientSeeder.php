<?php

namespace Database\Seeders;

use App\Models\Patient;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class PatientSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('pt_BR');

        $names = [
            // Airplane!
            'Anônio de Sousa',
            'Elaine Dickinson',
            'Diego Barbosa',
            'Clara Alves',
            'Roger Mauricio',
            'Rinaldo de Souza',
            'Tatiana de Souza',

            // Auto da Compadecida
            'João Grilo',
            'Francisco Santos',
            'João Almeida',
            'Beatriz Almeida',
            'Joaquim Severino',
            'Mariana Ximenes',
            'Pablo Silva',
            'Dorival dos Santos',
        ];

        foreach ($names as $name) {
            Patient::create([
                'name'             => $name,
                'cpf'              => $faker->cpf(false),
                'gender'           => $faker->randomElement(['Masculino', 'Feminino']),
                'phone'            => $faker->cellphoneNumber,
                'birth'            => $faker->dateTimeBetween('-70 years', '-18 years')->format('Y-m-d'),
                'emergency_number' => $faker->cellphoneNumber,
                'address'          => $faker->streetName,
                'number'           => $faker->buildingNumber,
                'complement'       => $faker->optional()->sentence,
                'neighborhood'     => $faker->streetSuffix,
                'city'             => $faker->city,
                'state'            => $faker->stateAbbr,
                'zip_code'         => $faker->postcode,
                'notes'            => $faker->optional()->sentence,
            ]);
        }
    }
}
