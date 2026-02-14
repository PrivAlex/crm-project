<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

/**
 * Создаёт роли пользователей в системе
 */
class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Создать роль "admin" (администратор)
        // Полный доступ ко всему + управление пользователями
        Role::create(['name' => 'admin']);

        // Создать роль "manager" (менеджер)
        // Работа с клиентами и сделками
        Role::create(['name' => 'manager']);

        // Создать роль "viewer" (наблюдатель)
        // Только просмотр данных
        Role::create(['name' => 'viewer']);
    }
}
