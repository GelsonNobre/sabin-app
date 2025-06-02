<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        OrderStatus::query()->delete();

        $statuses = [
            '1 - Em Preparação',
            '2 - Aguardando Pagamento',
            '3 - Pagamento Confirmado',
            '4 - Cancelada',
            '5 - Concluida',
        ];

        foreach ($statuses as $status) {
            OrderStatus::create([
                'name' => $status,
            ]);
        }
    }
}
