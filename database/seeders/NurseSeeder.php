<?php

namespace Database\Seeders;

use App\Models\Nurse;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NurseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Nurse::query()->delete();

        $nurses = [
            [
                'name'  => 'Fernanda Lima',
                'birth' => '1987-03-25',
                'phone' => '(61) 99876-4321',
                'email' => 'fernanda.lima@barezzi.com.br',
                'coren' => '123456-DF',
            ],
            [
                'name'  => 'Carlos Menezes',
                'birth' => '1990-07-10',
                'phone' => '(61) 98765-1234',
                'email' => 'carlos.menezes@barezzi.com.br',
                'coren' => '789012-DF',
            ],
            [
                'name'  => 'Juliana Rocha',
                'birth' => '1993-11-18',
                'phone' => '(61) 99654-7890',
                'email' => 'juliana.rocha@barezzi.com.br',
                'coren' => '345678-DF',
            ],
        ];

        foreach ($nurses as $nurse) {
            Nurse::create($nurse);
        }
    }
}
