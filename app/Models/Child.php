<?php

namespace App\Models;

use Haruncpi\LaravelUserActivity\Traits\Loggable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Child extends Model
{
    use HasFactory, Loggable;

    protected $fillable = [
        'f_name',
        'l_name',
        'm_name',
        'born_at',
        'born_place',
        'address_id',
        'flat',
        'gender',
        'citizenship',
        'birth_certificate_created_at',
        'birth_certificate_number',
        'birth_certificate_seria_a',
        'birth_certificate_seria_b',
        'doc_type',
        'doc_seria',
        'doc_number',
        'doc_date',
        'snils',
        'oms_policy',
        'dou_place',
        'ou_place',
        'npo_place',
        'spo_place',
        'vpo_place',
        'work_place',
        'no_work_reason',
        'phone',
        'email',
        'fact_address_id',
        'fact_flat',
        'child_category_id',
        'alien_doc',
        'user_id',
        'parent_id',
        'deleted_at',
        'dou_guid',
        'municipality_str',
        'district_str',
        'fact_address_str',
        'child_category_str',
        'status',
        'house_id',
        'fact_house_id',
        'fias_fact_house_id',
        'address_equal',
        'from_rpgu',
        'address_str',
        'registration_doc',
        'parent_passport',
        'birth_certificate',
    ];

    public function getAll(): Collection|array
    {
        return self::all();
    }

    public function getByParent(int $id): Collection|array
    {
        return self::all();
    }

    public function parent(): HasOne
    {
        return $this->HasOne(Parents::class);
    }

    public function house(): BelongsTo
    {
        return $this->belongsTo(House::class)->withDefault();
    }

    public function factHouse(): BelongsTo
    {
        return $this->belongsTo(House::class, 'fact_house_id')->withDefault();
    }

    public function getCategory()
    {
        return $this->child_category_id == 1 ? 'Нет' : 'Да';
    }

    public function changeStatus()
    {
        $this->status = 0;
        $this->deleted_at = now();
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
        return $this->f_name . ' ' . $this->m_name . ' ' . $this->l_name;
    }

    public function school()
    {
        $house = SchoolAddress::select('school_id')->where('house_id', $this->house_id)->get();

        return $house ? School::findOrFail($house) : [];
    }
}
