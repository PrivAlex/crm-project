<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->id();

            // К какой сделке относится активность
            $table->foreignId('deal_id')
                ->constrained('deals')
                ->onDelete('cascade');  // Удалить активности если удалили сделку

            // Кто создал активность (какой менеджер)
            $table->foreignId('user_id')
                ->constrained('users');

            // Тип активности
            $table->enum('type', [
                'call',     // Звонок
                'email',    // Email
                'meeting',  // Встреча
                'note'      // Заметка
            ]);

            // Описание активности (что произошло)
            $table->text('description');

            $table->timestamps();

            // Индекс для быстрого получения всех активностей сделки
            $table->index('deal_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
