<?php

namespace App\Models;

use Haruncpi\LaravelUserActivity\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory, Loggable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'school_id',
        'street_id',
        'house_id',
    ];

    public function make(array $data)
    {
        return self::create($data);
    }

    public function upgrade(array $data, $address)
    {
        $address->update($data);
    }
}
