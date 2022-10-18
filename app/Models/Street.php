<?php

namespace App\Models;

use Haruncpi\LaravelUserActivity\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Street extends Model
{
    use HasFactory, Loggable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'guid',
        'title',
    ];

    public function getHouses(): int
    {
        return $this->hasMany(House::class)->count();
    }

    public function make(array $data)
    {
        return self::create($data);
    }
}
