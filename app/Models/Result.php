<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Result extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'parsing_id',
        'href',
        'code',
        'parent',
        'anchor',
    ];

    public function parsing(): BelongsTo
    {
        return $this->belongsTo(Parsing::class)->withDefault();
    }

}
