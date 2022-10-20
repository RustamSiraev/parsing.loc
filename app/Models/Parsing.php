<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Parsing extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'href',
        'start',
        'stop',
        'end',
        'checked',
        'broken',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->withDefault();
    }

    public function results(): HasMany
    {
        return $this->hasMany(Result::class, 'parsing_id');
    }

    public function time(): int
    {
        return strtotime($this->stop) - strtotime($this->start);
    }

    public function getAll(): Collection|array
    {
        return self::all();
    }
}
