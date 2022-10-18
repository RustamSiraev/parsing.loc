<?php

namespace App\Models;

use Haruncpi\LaravelUserActivity\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;

class College extends Model
{
    use HasFactory, Loggable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'full_title',
        'address_id',
        'director_id',
        'phone',
        'status',
        'email',
        'jur_name',
        'ogrn',
        'inn',
        'kpp',
        'r_acc',
        'c_acc',
        'bank_name',
        'bank_bik',
        'okpo',
        'post_address',
        'jur_address',
        'start_filing',
        'address_str',
        'ek_acc',
        'k_acc',
        'l_acc',
        'bl_acc',
    ];

    public function getAll(): Collection|array
    {
        return self::all();
    }

    public function getAllActive(): Collection|array
    {
        return self::where('status', 1)->get();
    }

    public function isDeleted(): bool
    {
        return $this->status == 3;
    }

    public function getUsers(): int
    {
        return $this->hasMany(User::class)->count();
    }

    public function director(): BelongsTo
    {
        return $this->belongsTo(User::class, 'director_id')->withDefault();
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function specialities(): HasMany
    {
        return $this->hasMany(Speciality::class);
    }

    public function results(): hasManyThrough
    {
        return $this->hasManyThrough('App\Models\Result', 'App\Models\Speciality');
    }

    public function statements(): hasManyThrough
    {
        return $this->hasManyThrough('App\Models\Statement', 'App\Models\Speciality');
    }

    public function applicants(): Collection|array
    {
        $applicants = Applicant::where('created_from', $this->id)->pluck('id')->toArray();

        return Applicant::whereIn('id', array_merge($applicants, array_unique(self::statements()->pluck('applicant_id')->toArray())))->get();
    }

    public function activeSpecialities(array $arr = [1,2,3]): Collection
    {
        return self::specialities()->where('status', 1)->whereIn('education_form', $arr)->get();
    }

    public function educationForm()
    {
        $array = [
            [
                'id' => 1,
                'title' => 'Очная',
            ],
            [
                'id' => 2,
                'title' => 'Очно-заочная',
            ],
            [
                'id' => 3,
                'title' => 'Заочная',
            ],
        ];
        return array_filter($array, function ($v) {
            return in_array($v['id'], array_unique(self::activeSpecialities()->pluck('education_level')->toArray()));
        });
    }

    public function getStatusValue()
    {
        $array = [
            1 => 'Активен',
            2 => 'Заблокирован',
            3 => 'Удален',
        ];

        return $array[$this->status];
    }

    public function make(array $data)
    {
        return self::create($data);
    }

    public function upgrade(array $data, $college)
    {
        $college->update($data);
    }

    public function refreshDirector()
    {
        $user = User::findOrFail($this->director_id);
        $user->college_id = $this->id;
        $user->save();
    }

    public function changeStatus(int $step)
    {
        if ($step == 1) {
            $this->status = $this->status == 1 ? 2 : 1;
        } else {
            $this->status = $this->status == 3 ? 1 : 3;
        }
        self::save();
    }
}
