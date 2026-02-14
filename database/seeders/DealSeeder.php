<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\Client;
use App\Models\Deal;
use Illuminate\Database\Seeder;

/**
 * Создаёт тестовые сделки и активности
 */
class DealSeeder extends Seeder
{
    public function run(): void
    {
        // Получить ВСЕХ клиентов из БД
        $clients = Client::all();

        // Для каждого клиента создать 1-3 сделки
        foreach ($clients as $client) {
            // Случайное количество сделок для клиента (от 1 до 3)
            $dealsCount = rand(1, 3);

            // Создать сделки
            for ($i = 0; $i < $dealsCount; $i++) {

                // Создать сделку
                $deal = Deal::create([
                    'client_id' => $client->id,
                    'manager_id' => $client->manager_id,  // Тот же менеджер что у клиента
                    'title' => fake()->sentence(3),  // Случайное название
                    'amount' => fake()->randomFloat(2, 5000, 150000),  // От 5k до 150k
                    'status' => fake()->randomElement([
                        'new',
                        'contacted',
                        'qualified',
                        'proposal',
                        'negotiation',
                        'won',
                        'lost'
                    ]),
                    'expected_close_date' => fake()->dateTimeBetween('now', '+6 months'),
                ]);

                // Для каждой сделки создать 2-5 активностей (история действий)
                $activitiesCount = rand(2, 5);

                Activity::factory($activitiesCount)->create([
                    'deal_id' => $deal->id,
                    'user_id' => $client->manager_id,  // Менеджер создал активность
                ]);
            }
        }

        // ИТОГО:
        // ~70 клиентов × 2 сделки = ~140 сделок
        // ~140 сделок × 3.5 активностей = ~490 активностей
    }
}
