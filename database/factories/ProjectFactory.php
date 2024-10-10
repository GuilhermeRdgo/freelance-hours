<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(),
            'description' => fake()->paragraph(),
            'ends_at' => fake()->dateTimeBetween('now', '+3 days'),
            'status' => fake()->randomElement(['open', 'closed']),
            'tech_stack' => fake()->randomElement([
                'react', 'php', 'laravel', 'javascript', 'typescript', 'node', 'python', 'c#', 'java', 'ruby', 'go', 'rust', 'c++', 'swift', 'kotlin', 'dart', 'scala',
            ], random_int(1, 16)),
            'created_by' => User::factory(),
        ];
    }
}
