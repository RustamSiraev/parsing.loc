<?php

namespace App\Models;

use Haruncpi\LaravelUserActivity\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Testing extends Model
{
    use HasFactory, Loggable;

    protected $fillable = [
        'name',
        'speciality_id',
        'grade',
    ];

    public function speciality(): BelongsTo
    {
        return $this->belongsTo(Speciality::class)->withDefault();
    }

    public function statusValue(): string
    {
        return $this->status ? 'Активно' : 'Заблокировано';
    }

    public function gradeValue(): string
    {
        $array = [
            1 => 'Зачет / Незачет',
            2 => '5 бальная оценка',
            3 => '10 бальная оценка',
            4 => '100 бальная оценка',
        ];

        return $array[$this->grade];
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
