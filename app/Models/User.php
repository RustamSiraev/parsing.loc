<?php

namespace App\Models;

use App\Traits\HasRolesAndPermissions;
use Haruncpi\LaravelUserActivity\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Collection;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRolesAndPermissions, Loggable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'role_id',
        'college_id',
        'applicant_id',
        'password',
        'sign_in_count',
        'current_sign_in_at',
        'current_sign_in_ip',
        'last_sign_in_at',
        'last_sign_in_ip',
        'gender',
        'born_at',
        'snils',
        'is_director',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function applicant(): BelongsTo
    {
        return $this->belongsTo(Applicant::class)->withDefault();
    }

    public function isAdmin(): bool
    {
        return $this->id == 1;
    }

    public function isDirector(): bool
    {
        return $this->is_director;
    }

    public function isActivity(): bool
    {
        return Activity::where('user_id', $this->id)->first();
    }

    public function colleagues()
    {
        return self::where('college_id', $this->college_id)->pluck('id')->toArray();
    }

    public function isMy(): bool
    {
        return $this->id == auth()->user()->id;
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class)->withDefault();
    }

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class)->withDefault();
    }

    public function college(): BelongsTo
    {
        return $this->belongsTo(College::class)->withDefault();
    }

    public function directors(): Collection|array
    {
        return self::where('role_id', 2)->where('is_director', true)->get();
    }

    public function getAll(): Collection|array
    {
        return self::all();
    }

    public function getEmployees(): Collection|array
    {
        return self::where('role_id', '<', 4)->get();
    }

    public function getApplicants(): Collection|array
    {
        return self::where('role_id', 3)->get();
    }

    public function getCollege(): string
    {
        return $this->college_id ? College::findOrFail($this->college_id)->title : '';
    }

    public function getParentFullName()
    {
        return Parents::findOrFail($this->parent_id)->getFullName();
    }

    public function getStatusValue()
    {
        $array = [
            false => 'Заблокирован',
            true => 'Активен',
        ];

        return $array[$this->status];
    }

    public function getRole()
    {
        if ($this->role_id == 2 && !$this->is_director)
        {
            return Role::findOrFail(3)->name;
        }
        return Role::findOrFail($this->role_id)->name;
    }

    public function make(array $data)
    {
        return self::create($data);
    }

    public function upgrade(array $data, $post)
    {
        $post->update($data);
    }

    public function changeStatus()
    {
        $this->status = !$this->status;
        self::save();
    }

    public function home(): string
    {
        switch ($this->role_id) {
            case 1:
                return '/admin';
            case 2:
            case 3:
                return '/college';
            case 4:
                return '/applicant';
        }
    }
}
