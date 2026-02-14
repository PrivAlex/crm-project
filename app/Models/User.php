<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;  // ← Добавили

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;  // ← Добавили HasRoles

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // ↓ Добавили эти методы
    public function clients()
    {
        return $this->hasMany(Client::class, 'manager_id');
    }

    public function deals()
    {
        return $this->hasMany(Deal::class, 'manager_id');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class, 'assigned_to');
    }

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }
}
