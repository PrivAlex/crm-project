<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone', 50)->nullable();
            $table->string('company')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            // Связь с пользователем (менеджером)
            // Если удалить пользователя - удалятся его клиенты
            $table->foreignId('manager_id')->constrained('users')->onDelete('cascade');


            $table->index('manager_id');
            $table->index('email');
            $table->index('company');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
