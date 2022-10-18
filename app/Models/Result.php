<?php

namespace App\Models;

use Haruncpi\LaravelUserActivity\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Result extends Model
{
    use HasFactory, Loggable;

    protected $fillable = [
        'speciality_id',
        'user_id',
        'data',
        'ids',
        'status',
    ];

    public function speciality(): BelongsTo
    {
        return $this->belongsTo(Speciality::class)->withDefault();
    }

    public function getSpeciality()
    {
        return Speciality::findOrFail($this->speciality_id);
    }

    public function statusValue(): string
    {
        return $this->status ? 'Активен' : 'Заблокирован';
    }

    public function isMy()
    {
        return Speciality::findOrFail($this->speciality_id)->college_id == auth()->user()->college_id;
    }

    public function changeStatus()
    {
        $this->status = !$this->status;
        self::save();
    }
}

