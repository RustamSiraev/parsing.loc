<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Collection;

class Role extends Model
{
    use HasFactory;

    /**
     * Связь модели Role с моделью Users, позволяет получить
     * всех пользователей с этой ролью
     */
    public function users(): BelongsToMany
    {
        return $this
            ->belongsToMany(User::class, 'user_role')
            ->withTimestamps();
    }

    public function getAll(): Collection|array
    {
        return self::all();
    }
}
