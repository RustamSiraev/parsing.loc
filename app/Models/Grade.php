<?php

namespace App\Models;

use Carbon\Carbon;
use Haruncpi\LaravelUserActivity\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Grade extends Model
{
    use HasFactory, Loggable;

    protected $fillable = [
        'school_id',
        'number',
        'letter',
        'category',
        'capacity',
        'study_year_id',
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(School::class)->withDefault();
    }

    public function year()
    {
        $year = Carbon::createFromFormat('Y-m-d H:i:s', StudyYear::findOrFail($this->study_year_id)->begin_at)->year;
        return $year.'/'.$year+1;
    }

    public function make(array $data)
    {
        return self::create($data);
    }

    public function upgrade(array $data, $post)
    {
        $post->update($data);
    }

    public function getStudents()
    {
        return null;
    }

    public function getBids()
    {
        return null;
    }
}
