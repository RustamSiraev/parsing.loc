<?php

namespace App\Models;

use Haruncpi\LaravelUserActivity\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use phpDocumentor\Reflection\Types\Self_;

class Statement extends Model
{
    use HasFactory, Loggable;

    protected $fillable = [
        'user_id',
        'status_id',
        'message',
        'created_from',
        'applicant_id',
        'speciality_id',
        'deleted_at',
        'first',
        'target',
        'benefit',
        'limited',
        'disabled',
        'accepted_at',
        'rejected_at',
        'going_at',
        'going_at',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->withDefault();
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(StatementStatus::class)->withDefault();
    }

    public function applicant(): BelongsTo
    {
        return $this->belongsTo(Applicant::class)->withDefault();
    }

    public function getApplicant()
    {
        return Applicant::findOrFail($this->applicant_id);
    }

    public function college()
    {
        return self::speciality()->college();
    }

    public function speciality(): BelongsTo
    {
        return $this->belongsTo(Speciality::class)->withDefault();
    }

    public function getSpeciality()
    {
        return Speciality::findOrFail($this->speciality_id);
    }

    public function resultsList(): array
    {
        $arr = [];
        $result = self::getSpeciality()->getResult();

        $testings = self::getSpeciality()->testings()->pluck('name', 'id')->toArray();
        if ($result) {
            $grades = json_decode($result->data, true);
            if (in_array($this->applicant_id, explode(',', $result->ids))) {
                foreach ($grades['grade'][$this->applicant_id] as $key => $item) {
                    if (Testing::findOrFail($key)->grade == 1) {
                        $grade = $item == 1 ? 'Зачет' : 'Незачет';
                        $arr[] = $testings[$key] . ' - ' . $grade;
                    } else {
                        $arr[] = $testings[$key] . ' - ' . $item;
                    }
                }
            }

        }
        return $arr;
    }

    public function getCollege()
    {
        return College::findOrFail(self::getSpeciality()->college_id);
    }

    public function getStatus()
    {
        return StatementStatus::findOrFail($this->status_id)->name;
    }

    public function getFrom(): string
    {
        $array = [
            1 => 'Подана абитуриентом',
            2 => 'Создана СПО',
        ];

        return $array[$this->created_from];
    }

    public function make(array $data)
    {
        return self::create($data);
    }

    public function isMy(): bool
    {
        return $this->applicant_id == auth()->user()->applicant_id;
    }

    public function accept()
    {
        $this->status_id = 2;
        $this->accepted_at = now();
        self::save();
    }

    public function reject(string $message)
    {
        $this->status_id = 4;
        $this->message = $message;
        $this->rejected_at = now();
        self::save();
    }

    public function refute()
    {
        $this->status_id = 1;
        $this->accepted_at = NULL;
        $this->rejected_at = NULL;
        $this->message = '';
        self::save();
    }

    public function going()
    {
        $this->status_id = 3;
        $this->going_at = now();
        self::save();
    }

    public function refuse()
    {
        $this->status_id = 5;
        $this->refused_at = now();
        self::save();
    }
}
