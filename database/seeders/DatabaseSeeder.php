<?php

namespace Database\Seeders;

use App\Models\{User};
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name'     => 'Suporte',
            'email'    => 'suporte@barezzi.com.br',
            'password' => Hash::make('12345678'),
        ]);
        User::factory()->create([
            'name'     => 'Administrador',
            'email'    => 'admin@barezzi.com.br',
            'password' => Hash::make('12345678'),
        ]);
        User::factory()->create([
            'name'     => 'Lucas Junio',
            'email'    => 'lucas@barezzi.com.br',
            'password' => Hash::make('12345678'),
        ]);

        User::factory()->create([
            'name'     => 'Adriana Silva',
            'email'    => 'adriana@barezzi.com.br',
            'password' => Hash::make('12345678'),
        ]);

        User::factory()->create([
            'name'     => 'David Wesley',
            'email'    => 'david@barezzi.com.br',
            'password' => Hash::make('12345678'),
        ]);

        User::factory()->create([
            'name'     => 'João Silva',
            'email'    => 'joao@barezzi.com.br',
            'password' => Hash::make('12345678'),
        ]);

        $this->call([
            RoleSeeder::class,
            ModuleSeeder::class,
            PermissionSeeder::class,
            AttributeSeeder::class,
            MedicationSeeder::class,
        ]);
    }
}
