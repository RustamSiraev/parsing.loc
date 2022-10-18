<?php

namespace App\Models;

use Haruncpi\LaravelUserActivity\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Permission extends Model
{
    use HasFactory, Loggable;

    public function roles(): BelongsToMany
    {
        return $this
            ->belongsToMany(Role::class, 'role_permission')
            ->withTimestamps();
    }

    /**
     * Связь модели Permission с моделью User, позволяет получить
     * всех пользователей с этим правом
     */
    public function users(): BelongsToMany
    {
        return $this
            ->belongsToMany(User::class, 'user_permission')
            ->withTimestamps();
    }
}
