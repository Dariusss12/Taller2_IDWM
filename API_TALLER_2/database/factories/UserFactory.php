<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'name' => $this->faker->firstName,
            'lastname' => $this->faker->lastName,
            'id_number' => $this->faker->unique()->numberBetween(12343459, 999999999),
            'email' => $this->faker->unique()->safeEmail,
            'points_earned' => $this->faker->numberBetween(0, 999999),
        ];
    }
}
