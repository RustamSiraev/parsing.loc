<?php

namespace App\Models;

use Haruncpi\LaravelUserActivity\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Collection;

class Role extends Model
{
    use HasFactory, Loggable;

    public function permissions(): BelongsToMany
    {
        return $this
            ->belongsToMany(Permission::class, 'role_permission')
            ->withTimestamps();
    }

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

    public function getEmployees(array $roles = [1,2,3]): Collection|array
    {
        return self::whereIn('id', $roles)->get();
    }
}
