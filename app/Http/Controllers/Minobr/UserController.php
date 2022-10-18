<?php

namespace App\Http\Controllers\Minobr;

use App\Http\Controllers\AdminController;
use App\Http\Requests\PasswordRequest;
use App\Http\Requests\UserRequest;
use App\Models\Rano;
use App\Models\Role;
use App\Models\School;
use App\Models\User;
use Hash;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UserController extends AdminController
{
    private $user;
    private $role;
    private $school;
    private $rano;

    public function __construct(
        User $user,
        Rano $rano,
        Role $role,
        School $school,
    )
    {
        parent::__construct();
        $this->user = $user;
        $this->role = $role;
        $this->rano = $rano;
        $this->school = $school;
    }

    public function create(Request $request): Factory|View|Application
    {
        if ($request->has('rano')) {
            $rano = $this->rano->findOrFail($request->query('rano'));
            $back = '/minobr/ranos/'.$rano->id.'/users';
            return view('minobr.user.create', compact('rano', 'back'));
        }
        if ($request->has('school')) {
            $school = $this->school->findOrFail($request->query('school'));
            $back = '/minobr/schools/'.$school->id.'/users';
            return view('minobr.user.create', compact('school', 'back'));
        }
    }

    public function edit(int $id): Factory|View|Application
    {
        $user = User::findOrFail($id);
        if ($user->role_id == 5) {
            $back = '/minobr/ranos/'.$user->rano_id.'/users';
        } else {
            $back = '/minobr/schools/'.$user->school_id.'/users';
        }

        return view('minobr.user.edit', compact('user', 'back'));
    }

    public function store(UserRequest $request): RedirectResponse
    {
        $request->request->add(['password' => Hash::make(Str::random(10))]);
        $user = $this->user->make($request->all());

        return redirect()
            ->route('minobr.users.edit', compact('user'))
            ->with('success', 'Новый пользователь успешно создан');
    }

    public function update(UserRequest $request, User $user): RedirectResponse
    {
        $this->user->upgrade($request->all(), $user);

        return redirect()
            ->route('minobr.users.edit', compact('user'))
            ->with('success', 'Пользователь успешно изменён');
    }

    public function password(int $id): Factory|View|Application
    {
        $user = User::findOrFail($id);
        if ($user->role_id == 5) {
            $back = '/minobr/ranos/'.$user->rano_id.'/users';
        } else {
            $back = '/minobr/schools/'.$user->school_id.'/users';
        }

        return view('auth.passwords.change-password', compact('user', 'back'));
    }
}
