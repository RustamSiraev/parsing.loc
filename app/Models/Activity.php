<?php

namespace App\Models;

use DB;
use Haruncpi\LaravelUserActivity\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Activity extends Model
{
    use HasFactory, Loggable;

    protected $table = 'logs';

    public function getAll(): Collection|array
    {
        if (auth()->user()->isAdmin()) {
            return self::all();
        } else {
            $applicants = College::findOrFail(auth()->user()->college_id)->applicants()->pluck('id')->toArray();
            $users = User::whereIn('applicant_id', $applicants)->pluck('id')->toArray();
            return self::whereIn('user_id', array_merge(auth()->user()->colleagues(), $users))->get();
        }
    }

    public function getType(): string
    {
        $array = [
            'create' => 'Создание',
            'edit' => 'Редактирование',
            'login' => 'Вход',
            'delete' => 'Удаление',
        ];

        return $array[$this->log_type];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->withDefault();
    }

    public function getModel(): string
    {
        $array = [
            'users' => 'Пользователи',
            'roles' => 'Роли',
            'streets' => 'Адреса',
            'statements' => 'Заявления',
            'news' => 'Новости',
            'houses' => 'Адреса',
            'colleges' => 'СПО',
            'applicants' => 'Абитуриенты',
            'diplomas' => 'Аттестаты',
            'files' => 'Файлы',
            'specialities' => 'Специальности',
            'qualifications' => 'Квалификации',
            'testings' => 'Испытания',
            'results' => 'Результаты испытаний',
        ];

        return $this->table_name ? $array[$this->table_name] : '';
    }

    public function getData(): array
    {
        $data['before'] = json_decode($this->data, true);
        $data['after'] = [];
        if ($this->log_type != 'login') {
            $result = DB::select('select * from ' . $this->table_name . ' where id = :id', ['id' => $data['before']['id']]);
            $data['after'] = $result ? json_decode(json_encode($result[0]), true) : [];
        }
        return $data;
    }
}
