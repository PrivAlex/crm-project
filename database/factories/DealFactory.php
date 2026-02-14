<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Deal>
 */
class DealFactory extends Factory
{
    public function definition(): array
    {
        return [
            // Создаст случайного клиента
            'client_id' => Client::factory(),

            // Создаст случайного менеджера
            'manager_id' => User::factory(),

            // Название сделки (3 случайных слова)
            // Пример: "Cloud Migration Services"
            'title' => fake()->sentence(3),

            // Случайная сумма от 1,000 до 100,000
            // randomFloat(знаков_после_запятой, мин, макс)
            'amount' => fake()->randomFloat(2, 1000, 100000),

            // Случайный статус из массива
            'status' => fake()->randomElement([
                'new',
                'contacted',
                'qualified',
                'proposal',
                'negotiation',
                'won',
                'lost'
            ]),

            // Случайная дата от сегодня до +3 месяца
            'expected_close_date' => fake()->dateTimeBetween('now', '+3 months'),
        ];
    }
}
