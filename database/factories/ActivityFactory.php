<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Activity>
 */
class ActivityFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => fake()->randomNumber(6),
            'start_date' => fake()->date(),
            'type' => fake()->word(),
            'sub_type_1' => fake()->word(),
            'number_of_sets_1' => fake()->randomNumber(1, true),
            'number_of_reps_1' => fake()->randomNumber(3, true),
            'weight_1' => fake()->randomNumber(3, true),
            'sub_type_2' => fake()->word(),
            'number_of_sets_2' => fake()->randomNumber(1, true),
            'number_of_reps_2' => fake()->randomNumber(2, true),
            'weight_2' => fake()->randomNumber(3, true),
            'sub_type_3' => fake()->word(),
            'number_of_sets_3' => fake()->randomNumber(1, true),
            'number_of_reps_3' => fake()->randomNumber(2, true),
            'weight_3' => fake()->randomNumber(3, true),
            'distance' => fake()->randomNumber(5, true),
        ];
    }
}
