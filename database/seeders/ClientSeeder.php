<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\User;
use Illuminate\Database\Seeder;

/**
 * Создаёт тестовых клиентов для каждого менеджера
 */
class ClientSeeder extends Seeder
{
    public function run(): void
    {
        // Получить ВСЕХ пользователей с ролью "manager"
        $managers = User::role('manager')->get();

        // Для каждого менеджера создать 8-12 клиентов
        foreach ($managers as $manager) {
            // rand(8, 12) - случайное число от 8 до 12
            $clientsCount = rand(8, 12);

            // Создать клиентов для этого менеджера
            Client::factory($clientsCount)->create([
                'manager_id' => $manager->id,  // Привязать к конкретному менеджеру
            ]);
        }

        // ИТОГО: 7 менеджеров × ~10 клиентов = ~70 клиентов
    }
}
