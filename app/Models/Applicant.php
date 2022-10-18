<?php

namespace App\Models;

use Haruncpi\LaravelUserActivity\Traits\Loggable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Applicant extends Model
{
    use HasFactory, Loggable;

    protected $fillable = [
        'f_name',
        'l_name',
        'm_name',
        'born_at',
        'born_place',
        'gender',
        'citizenship',
        'doc_type',
        'doc_seria',
        'doc_number',
        'doc_date',
        'doc_response',
        'snils',
        'flat',
        'fact_flat',
        'deleted_at',
        'status',
        'house_id',
        'fact_house_id',
        'matches',
        'additional_contact',
        'created_from',
    ];

    public function getUser()
    {
        return User::where('applicant_id', $this->id)->firstOrFail();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->withDefault();
    }

    public function diploma(): BelongsTo
    {
        return $this->belongsTo(Diploma::class)->withDefault();
    }

    public function getDiploma()
    {
        return Diploma::where('applicant_id', $this->id)->first();
    }

    public function documents(int $type): array
    {
        return $this->hasMany(File::class)->where('type', $type)->get()->toArray();
    }

    public function getAll(): Collection|array
    {
        return self::all();
    }

    public function house(): BelongsTo
    {
        return $this->belongsTo(House::class)->withDefault();
    }

    public function factHouse(): BelongsTo
    {
        return $this->belongsTo(House::class, 'fact_house_id')->withDefault();
    }

    public function getStatusValue(): string
    {
        $array = [
            false => 'Заблокирован',
            true => 'Активен',
        ];

        return $array[$this->status];
    }

    public function getDocType(): string
    {
        $array = [
            1 => 'Свидетельство о рождении',
            2 => 'Паспорт гражданина РФ',
            3 => 'Временное удостоверение гражданина РФ',
            4 => 'Вид на жительства лица без гражданства',
            5 => 'Иностранный паспорт',
            6 => 'Заграничный паспорт гражданина РФ',
        ];

        return $array[$this->doc_type] ?? 'Отсутствует';
    }

    public function changeStatus()
    {
        $this->status = !$this->status;
        User::where('applicant_id', $this->id)->first()->changeStatus();
        self::save();
    }

    public function make(array $data)
    {
        return self::create($data);
    }

    public function upgrade(array $data, $child)
    {
        $child->update($data);
    }

    public function getFullName(): string
    {
        $fullName = $this->f_name.' '.$this->m_name;
        if ($this->l_name != '') $fullName .= ' '.$this->l_name;
        return $fullName;
    }

    public function statements(): HasMany
    {
        return $this->hasMany(Statement::class, 'applicant_id');
    }
}
