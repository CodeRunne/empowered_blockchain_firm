<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "user_id" => new UserFactory(),
            "title" => fake()->sentence(),
            "slug" => Str(fake()->sentence())->slug(),
            "thumbnail" => "/posts/image.png",
            "content" => fake()->paragraph(8),
            "is_published" => false,
            "excerpt" => fake()->paragraph(2)
        ];
    }
}