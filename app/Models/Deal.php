<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deal extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'manager_id',
        'title',
        'amount',
        'status',
        'expected_close_date',
    ];

    /**
     * Преобразование типов (Casts)
     * Laravel автоматически приведёт данные к нужному типу
     */
    protected $casts = [
        'amount' => 'decimal:2',           // Число с 2 знаками после запятой
        'expected_close_date' => 'date',   // Преобразовать в объект Carbon (дата)
    ];

    /**
     * RELATIONSHIPS
     */

    /**
     * Клиент к которому относится сделка
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Менеджер который ведёт сделку
     */
    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    /**
     * Активности (история действий) по этой сделке
     */
    public function activities()
    {
        return $this->hasMany(Activity::class);
    }

    /**
     * Задачи связанные с этой сделкой
     */
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    /**
     * БИЗНЕС-ЛОГИКА
     */

    /**
     * Проверка: можно ли перейти в новый статус
     *
     * Пример:
     * $deal->status = 'new'
     * $deal->canTransitionTo('contacted')  // true
     * $deal->canTransitionTo('won')        // false (нельзя из new сразу в won)
     */
    public function canTransitionTo(string $newStatus): bool
    {
        // Карта разрешённых переходов
        $transitions = [
            'new' => ['contacted', 'lost'],
            'contacted' => ['qualified', 'lost'],
            'qualified' => ['proposal', 'lost'],
            'proposal' => ['negotiation', 'lost'],
            'negotiation' => ['won', 'lost'],
        ];

        // Получить массив разрешённых статусов для текущего статуса
        $allowedStatuses = $transitions[$this->status] ?? [];

        // Проверить есть ли новый статус в разрешённых
        return in_array($newStatus, $allowedStatuses);
    }

    /**
     * Получить список разрешённых переходов для текущего статуса
     *
     * Пример:
     * $deal->status = 'new'
     * $deal->getAllowedTransitions()  // ['contacted', 'lost']
     */
    public function getAllowedTransitions(): array
    {
        $transitions = [
            'new' => ['contacted', 'lost'],
            'contacted' => ['qualified', 'lost'],
            'qualified' => ['proposal', 'lost'],
            'proposal' => ['negotiation', 'lost'],
            'negotiation' => ['won', 'lost'],
        ];

        return $transitions[$this->status] ?? [];
    }
}
