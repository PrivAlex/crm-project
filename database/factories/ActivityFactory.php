<?php

namespace Database\Factories;

use App\Models\Deal;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Activity>
 */
class ActivityFactory extends Factory
{
    public function definition(): array
    {
        return [
            'deal_id' => Deal::factory(),
            'user_id' => User::factory(),

            // Случайный тип активности
            'type' => fake()->randomElement(['call', 'email', 'meeting', 'note']),

            // Параграф текста описания
            'description' => fake()->paragraph(),
        ];
    }
}
