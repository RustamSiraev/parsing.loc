<?php

namespace App\Models;

use Haruncpi\LaravelUserActivity\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Rano extends Model
{
    use HasFactory, Loggable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'guno_id',
        'region_id',
        'district_id',
    ];

    public function schools(): HasMany
    {
        return $this->hasMany(School::class);
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function getAll(): Collection|array
    {
        return self::all();
    }

    public function getSchools(): int
    {
        return $this->hasMany(School::class)->count();
    }

    public function getUsers(): int
    {
        return $this->hasMany(User::class)->count();
    }

    public function statements(): hasManyThrough
    {
        return $this->hasManyThrough('App\Models\Statement', 'App\Models\School');
    }
}
