<?php

namespace App\Models;

use Haruncpi\LaravelUserActivity\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

class Guno extends Model
{
    use HasFactory, Loggable;

    public function getAll(): Collection|array
    {
        return self::all();
    }
}
