<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Вызываем seeders В СТРОГОМ ПОРЯДКЕ!
        // Порядок важен из-за связей между таблицами

        $this->call([
            // 1. Сначала роли (нужны для пользователей)
            RoleSeeder::class,

            // 2. Потом пользователи (нужны для клиентов)
            UserSeeder::class,

            // 3. Потом клиенты (нужны для сделок)
            ClientSeeder::class,

            // 4. В конце сделки и активности
            DealSeeder::class,
        ]);

        // Вывести информацию в консоль
        $this->command->info('Database seeded successfully! 🎉');
    }
}
