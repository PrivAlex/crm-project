<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    /**
     * Поля которые можно массово заполнять
     * Это защита от mass assignment уязвимостей
     */
    protected $fillable = [
        'manager_id',
        'name',
        'email',
        'phone',
        'company',
        'notes',
    ];

    /**
     * RELATIONSHIPS (Связи с другими моделями)
     */

    /**
     * Менеджер который ведёт этого клиента
     * Один клиент → один менеджер (belongsTo)
     */
    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    /**
     * Сделки этого клиента
     * Один клиент → много сделок (hasMany)
     */
    public function deals()
    {
        return $this->hasMany(Deal::class);
    }
}
