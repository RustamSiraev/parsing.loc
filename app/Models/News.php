<?php

namespace App\Models;

use Haruncpi\LaravelUserActivity\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory, Loggable;

    protected $fillable = [
        'user_id',
        'title',
        'body',
    ];

    public function getAll()
    {
        return self::orderBy('created_at', 'desc')
            ->paginate(10)
            ->fragment('news');
    }

    public function getHome()
    {
        return self::orderBy('created_at', 'desc')
            ->limit(3)
            ->get();
    }
}
