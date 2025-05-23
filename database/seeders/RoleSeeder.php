<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            ['id' => 1, 'name' => 'Suporte', 'is_support' => true],
            ['id' => 2, 'name' => 'Administrador', 'is_support' => false],
            ['id' => 3, 'name' => 'Gerente', 'is_support' => false],
            ['id' => 4, 'name' => 'Atendente', 'is_support' => false],
            ['id' => 5, 'name' => 'Professor', 'is_support' => false],
        ]);

        DB::table('role_user')->insert([
            'role_id' => 1,
            'user_id' => 1,
        ]);

        DB::table('role_user')->insert([
            'role_id' => 2,
            'user_id' => 2,
        ]);

        DB::table('role_user')->insert([
            'role_id' => 2,
            'user_id' => 3,
        ]);

        DB::table('role_user')->insert([
            'role_id' => 2,
            'user_id' => 4,
        ]);

        DB::table('role_user')->insert([
            'role_id' => 2,
            'user_id' => 5,
        ]);

        DB::table('role_user')->insert([
            'role_id' => 2,
            'user_id' => 6,
        ]);

        DB::table('role_user')->insert([
            'role_id' => 2,
            'user_id' => 7,
        ]);

        DB::table('role_user')->insert([
            'role_id' => 5,
            'user_id' => 8,
        ]);
    }
}
