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
        'pid',
        'all_pages',
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
        if (!$this->stop)
        {
            return strtotime($this->updated_at) - strtotime($this->start);
        }
        return strtotime($this->stop) - strtotime($this->start);
    }

    public function getAll($id = false): Collection|array
    {
        if ($id)
        {
            return self::where('user_id', $id)->get();
        }
        if (auth()->user()->isAdmin())
        {
            return self::all();
        }
        return self::where('user_id', auth()->user()->id)->get();
    }

    public function isMy(): bool
    {
        if (auth()->user()->isAdmin())
        {
            return true;
        }
        return $this->user_id == auth()->user()->id;
    }
}
