<?php

namespace App\Traits;

use App\Models\Role;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait HasRoles
{
    /**
     * Связь модели User с моделью Role, позволяет получить все роли пользователя
     */
    public function roles(): BelongsToMany
    {
        return $this
            ->belongsToMany(Role::class, 'user_role')
            ->withTimestamps();
    }

    /**
     * Имеет текущий пользователь роль $role?
     */
    public function hasRole(string $role)
    {
        return $this->roles->contains('slug', $role);
    }

    /**
     * Возвращает массив всех ролей текущего пользователя
     */
    public function getAllRoles()
    {
        return $this->roles->pluck('slug')->toArray();
    }

    /**
     * Добавить текущему пользователю роли $roles
     * (в дополнение к тем, что уже были назначены)
     */
    public function assignRoles(...$roles): static
    {
        $roles = Role::whereIn('slug', $roles)->get();
        if ($roles->count() === 0)
        {
            return $this;
        }
        $this->roles()->syncWithoutDetaching($roles);
        return $this;
    }

    /**
     * Отнять у текущего пользователя роли $roles
     * (из числа тех, что были назначены ранее)
     */
    public function unAssignRoles(...$roles): static
    {
        $roles = Role::whereIn('slug', $roles)->get();
        if ($roles->count() === 0)
        {
            return $this;
        }
        $this->roles()->detach($roles);
        return $this;
    }

    /**
     * Назначить текущему пользователю роли $roles
     * (отнять при этом все ранее назначенные роли)
     */
    public function refreshRoles(...$roles): static
    {
        $roles = Role::whereIn('slug', $roles)->get();
        if ($roles->count() === 0)
        {
            return $this;
        }
        $this->roles()->sync($roles);
        return $this;
    }
}
