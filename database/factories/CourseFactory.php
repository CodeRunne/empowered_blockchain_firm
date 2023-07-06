<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Courses>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => new UserFactory(),
            'course_category_id' => new CourseCategoryFactory(),
            'title' => fake()->unique()->name(),
            'slug' => str(fake()->unique()->name())->slug(),
            'description' => fake()->sentence(2),
            'thumbnail' => 'courses/image.png',
            'body' => fake()->paragraph(12)
        ];
    }
}
