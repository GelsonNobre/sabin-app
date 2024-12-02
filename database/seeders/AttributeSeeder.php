<?php

namespace Database\Seeders;

use App\Models\Attribute;
use Illuminate\Database\Seeder;

class AttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Attribute::create(['id' => 1, 'name' => 'Cliente']);
        Attribute::create(['id' => 2, 'name' => 'Fornecedor']);
    }
}
