<?php

namespace App\Models;

use Haruncpi\LaravelUserActivity\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Qualification extends Model
{
    use HasFactory, Loggable;

    protected $fillable = [
        'name',
        'speciality_id',
    ];

    public function speciality(): BelongsTo
    {
        return $this->belongsTo(Speciality::class)->withDefault();
    }

    public function statusValue(): string
    {
        return $this->status ? 'Активна' : 'Заблокирована';
    }

    public function isMy()
    {
        return Speciality::findOrFail($this->speciality_id)->college_id == auth()->user()->college_id;
    }

    public function changeStatus()
    {
        $this->status = $this->status == 1 ? 0 : 1;
        self::save();
    }
}
