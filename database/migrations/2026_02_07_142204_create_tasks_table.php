<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();

            // Связь со сделкой (необязательно - может быть общая задача)
            $table->foreignId('deal_id')
                ->nullable()
                ->constrained('deals')
                ->onDelete('cascade');

            // Кому назначена задача
            $table->foreignId('assigned_to')
                ->constrained('users');

            // Кто создал задачу
            $table->foreignId('created_by')
                ->constrained('users');

            // Информация о задаче
            $table->string('title');                      // Название задачи
            $table->text('description')->nullable();      // Описание (необязательно)

            // Статус задачи
            $table->enum('status', [
                'pending',      // Ожидает выполнения
                'in_progress',  // В работе
                'completed'     // Завершена
            ])->default('pending');

            // Срок выполнения (необязательно)
            $table->date('due_date')->nullable();

            $table->timestamps();

            // Индексы
            $table->index('assigned_to');  // Задачи пользователя
            $table->index('status');       // Фильтр по статусу
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
