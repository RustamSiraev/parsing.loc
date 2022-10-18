<?php

namespace App\Models;

use Haruncpi\LaravelUserActivity\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Speciality extends Model
{
    use HasFactory, Loggable;

    protected $fillable = [
        'code',
        'name',
        'college_id',
        'education_level',
        'education_form',
        'budgetary',
        'commercial',
        'education_cost',
        'education_time',
        'status',
    ];

    public function college(): BelongsTo
    {
        return $this->belongsTo(College::class)->withDefault();
    }

    public function result(): BelongsTo
    {
        return $this->belongsTo(Result::class)->withDefault();
    }

    public function getResult()
    {
        return Result::where('speciality_id',$this->id)->first();
    }

    public function collegeName()
    {
        return College::findOrFail($this->college_id)->title;
    }

    public function educationLevel(): string
    {
        $array = [
            1 => 'Основное общее',
            2 => 'Среднее общее',
        ];

        return $array[$this->education_level];
    }

    public function educationForm(): string
    {
        $array = [
            1 => 'Очная',
            2 => 'Очно-заочная',
            3 => 'Заочная',
        ];

        return $array[$this->education_form];
    }

    public function qualifications(): HasMany
    {
        return $this->hasMany(Qualification::class);
    }

    public function testings(): HasMany
    {
        return $this->hasMany(Testing::class);
    }

    public function applicants()
    {
        $arr = array_unique(self::statements()->where('status_id', 2)->pluck('applicant_id')->toArray());

        return Applicant::whereIn('id', $arr)->get();
    }

    public function qualificationsList(): array
    {
        $arr = [];
        foreach (self::qualifications()->pluck('name')->toArray() as $key => $item) {
            $num = $key + 1;
            $arr[] = $num . '. ' . $item;
        }
        return $arr;
    }

    public function make(array $data)
    {
        return self::create($data);
    }

    public function upgrade(array $data, $speciality)
    {
        $speciality->update($data);
    }

    public function isMy(): bool
    {
        return $this->college_id == auth()->user()->college_id;
    }

    public function changeStatus()
    {
        $this->status = $this->status == 1 ? 0 : 1;
        self::save();
    }

    public function statements(): hasMany
    {
        return $this->hasMany(Statement::class, 'speciality_id');
    }
}
