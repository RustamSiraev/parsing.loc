<?php

namespace App\Models;

use Carbon\Carbon;
use Haruncpi\LaravelUserActivity\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StudyYear extends Model
{
    use HasFactory, Loggable;

    protected $fillable = [
        'begin_at',
        'current',
    ];

    public function grades(): HasMany
    {
        return $this->hasMany(Grade::class);
    }

    public function title(): string
    {
        $year = Carbon::createFromFormat('Y-m-d H:i:s', $this->begin_at)->year;
        return $year.'/'.$year+1;
    }
}
