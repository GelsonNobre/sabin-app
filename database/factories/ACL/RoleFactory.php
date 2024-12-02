<?php

namespace Database\Factories\ACL;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class RoleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'       => fake()->text(10),
            'is_support' => false,
        ];
    }

    public function support(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_support' => true,
        ]);
    }
}
