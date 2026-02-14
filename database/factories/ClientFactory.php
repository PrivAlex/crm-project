<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Factory для генерации тестовых клиентов
 *
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{
    /**
     * Определяет дефолтное состояние модели
     *
     * fake() - это helper Laravel для генерации фейковых данных
     * Под капотом использует библиотеку Faker
     */
    public function definition(): array
    {
        return [
            // Создаст случайного пользователя (менеджера)
            // Или можно передать конкретный ID: 'manager_id' => 1
            'manager_id' => User::factory(),

            // Случайное имя (John Doe, Jane Smith и т.д.)
            'name' => fake()->name(),

            // Уникальный email (john.doe@example.com)
            'email' => fake()->unique()->safeEmail(),

            // Телефон в формате +1-234-567-8901
            'phone' => fake()->phoneNumber(),

            // Название компании (Acme Corp, TechStart Inc и т.д.)
            'company' => fake()->company(),

            // Параграф текста (случайные заметки)
            'notes' => fake()->paragraph(),
        ];
    }
}
