<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'deal_id',
        'assigned_to',
        'created_by',
        'title',
        'description',
        'status',
        'due_date',
    ];

    protected $casts = [
        'due_date' => 'date',
    ];

    /**
     * RELATIONSHIPS
     */

    /**
     * Сделка к которой привязана задача (может быть null)
     */
    public function deal()
    {
        return $this->belongsTo(Deal::class);
    }

    /**
     * Пользователь которому назначена задача
     */
    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    /**
     * Пользователь который создал задачу
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
