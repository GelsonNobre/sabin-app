<?php

namespace Database\Factories\ACL;

use App\Models\ACL\Module;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class PermissionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->word();

        return [
            'name'      => $name,
            'module_id' => Module::factory(),
            'guard'     => $this->faker->randomElement(['read', 'write']) . '_' . $name,
        ];
    }
}
