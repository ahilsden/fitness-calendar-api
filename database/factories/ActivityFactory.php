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
            'startDate' => fake()->date(),
            'type' => fake()->word(),
            'subType1' => fake()->word(),
            'numberOfSets1' => fake()->randomNumber(2, true),
            'numberOfReps1' => fake()->randomNumber(3, true),
            'weight1' => fake()->randomNumber(3, true),
            'subType2' => fake()->word(),
            'numberOfSets2' => fake()->randomNumber(2, true),
            'numberOfReps2' => fake()->randomNumber(2, true),
            'weight2' => fake()->randomNumber(3, true),
            'subType3' => fake()->word(),
            'numberOfSets3' => fake()->randomNumber(2, true),
            'numberOfReps3' => fake()->randomNumber(2, true),
            'weight3' => fake()->randomNumber(3, true),
            'distance' => fake()->randomNumber(5, true),
        ];
    }
}
