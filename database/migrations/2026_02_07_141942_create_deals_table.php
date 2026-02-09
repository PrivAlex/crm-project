<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('deals', function (Blueprint $table) {
            // ID
            $table->id();

            // Связи с другими таблицами
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade');  // Удалить сделку если удалили клиента
            $table->foreignId('manager_id')->constrained('users');  // Связь с менеджером

            // Основная информация о сделке
            $table->string('title');  // Название сделки

            // Сумма сделки (15 цифр всего, 2 после запятой)
            // Пример: 1234567890123.45
            $table->decimal('amount', 15, 2);

            // Статус сделки (воронка продаж)
            $table->enum('status', [
                'new',          // Новая
                'contacted',    // Связались
                'qualified',    // Квалифицирован
                'proposal',     // Отправлено предложение
                'negotiation',  // Переговоры
                'won',          // Выиграли
                'lost'          // Проиграли
            ])->default('new');

            // Ожидаемая дата закрытия сделки (необязательно)
            $table->date('expected_close_date')->nullable();

            // Временные метки
            $table->timestamps();

            // Индексы
            $table->index('status');      // Фильтр по статусу
            $table->index('manager_id');  // Сделки менеджера
            $table->index('client_id');   // Сделки клиента
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('deals');
    }
};
