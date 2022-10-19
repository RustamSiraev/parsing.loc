<?php

namespace App\Models;

use App\Traits\HasRoles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Collection;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'role_id',
        'password',
        'avatar',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function isAdmin(): bool
    {
        return $this->id == 1;
    }

    public function isMy(): bool
    {
        return $this->id == auth()->user()->id;
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class)->withDefault();
    }

    public function getAll(): Collection|array
    {
        return self::all();
    }

    public function getStatusValue(): string
    {
        $array = [
            false => 'Заблокирован',
            true => 'Активен',
        ];

        return $array[$this->status];
    }

    public function make(array $data)
    {
        return self::create($data);
    }

    public function upgrade(array $data, $post)
    {
        $post->update($data);
    }

    public function changeStatus()
    {
        $this->status = !$this->status;
        self::save();
    }

    public function home(): string
    {
        switch ($this->role_id) {
            case 1:
                return '/admin';
            case 2:
                return '/';
        }
    }
}
