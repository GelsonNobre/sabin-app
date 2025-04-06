<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('modules')->insert([
            ['id' => 1, 'name' => 'Dashboard', 'route' => 'dashboard'],
            ['id' => 2, 'name' => 'Usuários', 'route' => 'users'],
            ['id' => 3, 'name' => 'Tipos de Usuários', 'route' => 'roles'],
            ['id' => 4, 'name' => 'Pessoas', 'route' => 'persons'],
            ['id' => 5, 'name' => 'Procedimentos', 'route' => 'procedures'],
            ['id' => 6, 'name' => 'Medicamentos', 'route' => 'medications'],
            ['id' => 7, 'name' => 'Estoques', 'route' => 'stocks'],
            ['id' => 8, 'name' => 'Pacientes', 'route' => 'patients'],
            ['id' => 9, 'name' => 'Ordens', 'route' => 'orders'],
            ['id' => 10, 'name' => 'Status de Ordens', 'route' => 'order-statuses'],
        ]);
    }
}
