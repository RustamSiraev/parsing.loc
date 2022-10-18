<?php

namespace App\Models;

use Haruncpi\LaravelUserActivity\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class School extends Model
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
        'rano_id',
        'address_id',
        'director',
        'phone',
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
    ];

    public function getAll(): Collection|array
    {
        return self::all();
    }

    public function getUsers(): int
    {
        return $this->hasMany(User::class)->count();
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function grades(): HasMany
    {
        return $this->hasMany(Grade::class);
    }

    public function addresses()
    {
        return SchoolAddress::where('school_id', $this->id)
            ->with('house')
            ->get();
    }

    public function getPlaces(): int
    {
        return $this->grades()->sum('capacity');
    }

    public function getOccupancy(): int
    {
        return $this->getPlaces() ? round(100 * ($this->getPlaces()) / $this->getPlaces()) : 0;
    }

    public function getStatusValue()
    {
        $array = [
            false => 'Не функционирует',
            true => 'Функционирует',
        ];

        return $array[$this->status];
    }

    public function make(array $data)
    {
        return self::create($data);
    }

    public function upgrade(array $data, $school)
    {
        $school->update($data);
    }

    public function rano(): BelongsTo
    {
        return $this->belongsTo(Rano::class)->withDefault();
    }

    public function statements(): hasMany
    {
        return $this->hasMany(Statement::class, 'school_id');
    }
}
