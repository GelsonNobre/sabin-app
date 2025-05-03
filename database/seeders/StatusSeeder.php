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
            'Em Preparação',
            'Aguardando Pagamento',
            'Pagamento Confirmado',
            'Estornado',
            'Cancelada',
        ];

        foreach ($statuses as $status) {
            OrderStatus::create([
                'name' => $status,
            ]);
        }
    }
}
