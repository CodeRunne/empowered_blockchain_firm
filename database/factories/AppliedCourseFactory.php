<?php

namespace Database\Factories;

use App\Models\{User, Course};
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AppliedCourse>
 */
class AppliedCourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::all()->random()->id,
            'course_id' => Course::all()->random()->id
        ];
    }
}
