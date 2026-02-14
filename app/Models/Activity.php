<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'deal_id',
        'user_id',
        'type',
        'description',
    ];

    /**
     * RELATIONSHIPS
     */

    /**
     * Сделка к которой относится активность
     */
    public function deal()
    {
        return $this->belongsTo(Deal::class);
    }

    /**
     * Пользователь который создал активность
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
