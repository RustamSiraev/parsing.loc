<?php

namespace App\Models;

use Haruncpi\LaravelUserActivity\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Parents extends Model
{
    use HasFactory, Loggable;

    protected $fillable = [
        'l_name',
        'f_name',
        'm_name',
        'category',
        'doc_type',
        'doc_type',
        'doc_seria',
        'doc_number',
        'doc_date',
        'citizenship',
        'additional_contact',
        'house_id',
        'flat',
    ];

    public function getUser()
    {
        return User::where('parent_id', $this->id)->firstOrFail();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->withDefault();
    }

    public function house(): BelongsTo
    {
        return $this->belongsTo(House::class)->withDefault();
    }

    public function getAll(): Collection|array
    {
        return self::all();
    }

    public function children(): HasMany
    {
        return $this->hasMany(Child::class, 'parent_id');
    }

    public function statements(): HasMany
    {
        return $this->hasMany(Statement::class, 'parent_id');
    }

    public function getChildren(): int
    {
        return $this->hasMany(Child::class, 'parent_id')->count();
    }

    public function getFullName(): string
    {
        return $this->f_name.' '.$this->m_name.' '.$this->l_name;
    }

    public function getStatusValue()
    {
        $array = [
            '0' => 'Удален',
            '1' => '',
        ];

        return $array[$this->status];
    }

    public function changeStatus()
    {
        $this->status = !$this->status;
        $this->deleted_at = $this->deleted_at ? null : now();
        self::getUser()->changeStatus();
        self::save();
    }

    public function make(array $data)
    {
        return self::create($data);
    }

    public function upgrade(array $data, $parent)
    {
        $parent->update($data);
    }
}
