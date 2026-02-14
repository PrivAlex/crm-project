<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Создаёт тестовых пользователей
 */
class UserSeeder extends Seeder
{
    public function run(): void
    {
        // ===== АДМИН =====
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@crm.test',
            'password' => Hash::make('password'),  // Хешируем пароль
        ]);
        // Назначить роль admin
        $admin->assignRole('admin');

        // ===== МЕНЕДЖЕРЫ (фиксированные) =====

        // Первый менеджер
        $manager1 = User::create([
            'name' => 'John Manager',
            'email' => 'john@crm.test',
            'password' => Hash::make('password'),
        ]);
        $manager1->assignRole('manager');

        // Второй менеджер
        $manager2 = User::create([
            'name' => 'Sarah Manager',
            'email' => 'sarah@crm.test',
            'password' => Hash::make('password'),
        ]);
        $manager2->assignRole('manager');

        // ===== СЛУЧАЙНЫЕ МЕНЕДЖЕРЫ =====
        // Создать ещё 5 случайных менеджеров
        User::factory(5)->create()->each(function ($user) {
            $user->assignRole('manager');
        });

        // ИТОГО: 1 админ + 7 менеджеров = 8 пользователей
    }
}
