<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->insert([
            ['id' => 1, 'module_id' => 1, 'name' => 'Ver', 'guard' => 'read_dashboard'],

            ['id' => 2, 'module_id' => 2, 'name' => 'Ver', 'guard' => 'read_users'],
            ['id' => 3, 'module_id' => 2, 'name' => 'Criar/Editar', 'guard' => 'write_users'],

            ['id' => 4, 'module_id' => 3, 'name' => 'Ver', 'guard' => 'read_roles'],
            ['id' => 5, 'module_id' => 3, 'name' => 'Criar/Editar', 'guard' => 'write_roles'],

            ['id' => 6, 'module_id' => 4, 'name' => 'Ver', 'guard' => 'read_persons'],
            ['id' => 7, 'module_id' => 4, 'name' => 'Criar/Editar', 'guard' => 'write_persons'],

            ['id' => 8, 'module_id' => 5, 'name' => 'Ver', 'guard' => 'read_procedures'],
            ['id' => 9, 'module_id' => 5, 'name' => 'Criar/Editar', 'guard' => 'write_procedures'],

            ['id' => 10, 'module_id' => 6, 'name' => 'Ver', 'guard' => 'read_medications'],
            ['id' => 11, 'module_id' => 6, 'name' => 'Criar/Editar', 'guard' => 'write_medications'],

            ['id' => 12, 'module_id' => 7, 'name' => 'Ver', 'guard' => 'read_stocks'],
            ['id' => 13, 'module_id' => 7, 'name' => 'Criar/Editar', 'guard' => 'write_stocks'],

            ['id' => 14, 'module_id' => 8, 'name' => 'Ver', 'guard' => 'read_patients'],
            ['id' => 15, 'module_id' => 8, 'name' => 'Criar/Editar', 'guard' => 'write_patients'],

            ['id' => 16, 'module_id' => 9, 'name' => 'Ver', 'guard' => 'read_orders'],
            ['id' => 17, 'module_id' => 9, 'name' => 'Criar/Editar', 'guard' => 'write_orders'],

            ['id' => 18, 'module_id' => 10, 'name' => 'Ver', 'guard' => 'read_order_statuses'],
            ['id' => 19, 'module_id' => 10, 'name' => 'Criar/Editar', 'guard' => 'write_order_statuses'],
        ]);

        //Role 2 - Administrador
        DB::table('permission_role')->insert([
            ['permission_id' => 1, 'role_id' => 2, ],
            ['permission_id' => 2, 'role_id' => 2, ],
            ['permission_id' => 3, 'role_id' => 2, ],
            ['permission_id' => 4, 'role_id' => 2, ],
            ['permission_id' => 5, 'role_id' => 2, ],
            ['permission_id' => 6, 'role_id' => 2, ],
            ['permission_id' => 7, 'role_id' => 2, ],
            ['permission_id' => 8, 'role_id' => 2, ],
            ['permission_id' => 9, 'role_id' => 2, ],
            ['permission_id' => 10, 'role_id' => 2, ],
            ['permission_id' => 11, 'role_id' => 2, ],
            ['permission_id' => 12, 'role_id' => 2, ],
            ['permission_id' => 13, 'role_id' => 2, ],
            ['permission_id' => 14, 'role_id' => 2, ],
            ['permission_id' => 15, 'role_id' => 2, ],
            ['permission_id' => 16, 'role_id' => 2, ],
            ['permission_id' => 17, 'role_id' => 2, ],
            ['permission_id' => 18, 'role_id' => 2, ],
            ['permission_id' => 19, 'role_id' => 2, ],
        ]);

        //Role 3 - Atendente
        DB::table('permission_role')->insert([
            ['permission_id' => 1, 'role_id' => 3, ], // Ler Dashboard
            ['permission_id' => 2, 'role_id' => 3, ], // read_users
            ['permission_id' => 6, 'role_id' => 2, ],
            ['permission_id' => 7, 'role_id' => 2, ],
            ['permission_id' => 8, 'role_id' => 2, ],
        ]);

        //Role 4 - Atendente
        DB::table('permission_role')->insert([
            ['permission_id' => 1, 'role_id' => 4, ], // Ler Dashboard
            ['permission_id' => 2, 'role_id' => 4, ], // read_users
            ['permission_id' => 8, 'role_id' => 2, ],
        ]);

        //Role 5 - Professor
        DB::table('permission_role')->insert([
            ['permission_id' => 1, 'role_id' => 5, ], // Ler Dashboard
            ['permission_id' => 2, 'role_id' => 5, ], // Entrega de 31/03/2025
            ['permission_id' => 3, 'role_id' => 5, ], // Entrega de 31/03/2025
            ['permission_id' => 4, 'role_id' => 5, ], // Entrega de 07/04/2025
            ['permission_id' => 5, 'role_id' => 5, ], // Entrega de 07/04/2025
        ]);
    }
}
