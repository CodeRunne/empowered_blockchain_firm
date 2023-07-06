<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\HireATeam>
 */
class HireATeamFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name,
            'email' => fake()->unique()->email,
            'job_role' => collect(['web developer', 'designer', 'software engineer'])->random(),
            'budget' => 100.5,
            'description' => fake()->sentence(50)
        ];
    }
}
