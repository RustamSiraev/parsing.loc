<?php

namespace App\Http\Controllers\College;

use App\Http\Controllers\AdminController;
use App\Http\Requests\PasswordRequest;
use App\Http\Requests\UserRequest;
use App\Models\Activity;
use App\Models\College;
use App\Models\News;
use App\Models\Role;
use App\Models\User;
use Auth;
use Hash;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class UserController extends AdminController
{
    private $user;
    private $role;
    private $news;
    private $college;
    private $activity;

    public function __construct(
        User $user,
        Role $role,
        News $news,
        College $college,
        Activity $activity,
    )
    {
        parent::__construct();
        $this->user = $user;
        $this->role = $role;
        $this->news = $news;
        $this->college = $college;
        $this->activity = $activity;
    }

    public function index(): View|Factory|Application
    {
        $news = $this->news->getAll();

        return view('admin.index', compact('news'));
    }

    public function users(): View|Factory|Application
    {
        return view('college.user.index');
    }

    public function getUsers(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->college->findOrFail(auth()->user()->college_id)->users->each(function ($item, $key) {
                $item->role_id = $item->getRole();
                $item->statusValue = $item->getStatusValue();
                $item->text = $item->status ? 'Заблокировать пользователя' : 'Разблокировать пользователя';
                $item->icon = $item->status ? 'bi-unlock' : 'bi-lock';
                $item->confirm = $item->status ? 'Вы подтверждаете блокирование?' : 'Вы подтверждаете разблокирование?';
            });
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    if (auth()->user()->isDirector()) {
                        if ($row->isMy()) {
                            return '<a class="text-frame" href="/college/users/' . $row->id . '/activity" title="История действий"><i class="bi bi-camera"></i></a>
                                <a class="text-frame" href="/college/users/' . $row->id . '/edit" title="Редактировать"><i class="bi bi-pencil"></i></a>';
                        } else {
                            return '<a class="text-frame" href="/college/users/' . $row->id . '/activity" title="История действий"><i class="bi bi-camera"></i></a>
                            <a class="text-frame" href="/college/users/' . $row->id . '/edit" title="Редактировать"><i class="bi bi-pencil"></i></a>
                            <a class="text-frame" href="/college/users/' . $row->id . '/password" title="Изменить пароль"><i class="bi bi-gear"></i></a>
                            <a class="text-frame confirm-id" href="#" title="' . $row->text . '" data-bs-toggle="modal" data-bs-target="#dataConfirmModal" data-id="' . $row->id . '"  data-confirm="' . $row->confirm . '"><i class="bi ' . $row->icon . '"></i></a>';
                        }
                    } else {
                        if ($row->isMy()) {
                            return '<a class="text-frame" href="/college/users/' . $row->id . '/activity" title="История действий"><i class="bi bi-camera"></i></a>
                                <a class="text-frame" href="/college/users/' . $row->id . '/edit" title="Редактировать"><i class="bi bi-pencil"></i></a>';
                        } elseif ($row->isDirector()) {
                            return '';
                        } else {
                            return '<a class="text-frame" href="/college/users/' . $row->id . '/activity" title="История действий"><i class="bi bi-camera"></i></a>
                            <a class="text-frame" href="/college/users/' . $row->id . '/edit" title="Редактировать"><i class="bi bi-pencil"></i></a>
                            <a class="text-frame" href="/college/users/' . $row->id . '/password" title="Изменить пароль"><i class="bi bi-gear"></i></a>
                            <a class="text-frame confirm-id" href="#" title="' . $row->text . '" data-bs-toggle="modal" data-bs-target="#dataConfirmModal" data-id="' . $row->id . '"  data-confirm="' . $row->confirm . '"><i class="bi ' . $row->icon . '"></i></a>';
                        }
                    }
                })
                ->addColumn('show', function ($row) {
                    return '<a class="decoration-none" href="/college/users/' . $row->id . '/show" title="Посмотреть">' . $row->name . '</a>';
                })
                ->rawColumns(['action', 'show'])
                ->make(true);
        }
    }

    public function show(int $id): Factory|View|Application
    {
        $user = $this->user->findOrFail($id);
        $back = 'college.users.index';

        return view('admin.user.show', compact('user', 'back'));
    }

    public function create(): Factory|View|Application
    {
        if (auth()->user()->isDirector()) {
            $roles = $this->role->getEmployees([2,3]);
        } else {
            $roles = $this->role->getEmployees([3]);
        }
        $college = $this->college->getAll();
        $route = 'college.users.store';
        $back = 'college.users.index';

        return view('admin.user.create', compact('roles', 'college', 'route', 'back'));
    }

    public function edit(int $id): Factory|View|Application
    {
        $user = $this->user->findOrFail($id);
        if (auth()->user()->isDirector()) {
            $roles = $this->role->getEmployees([2,3]);
        } else {
            $roles = $this->role->getEmployees([3]);
        }
        $college = $this->college->getAll();
        $route = 'college.users.update';
        $back = 'college.users.index';

        return view('admin.user.edit', compact('user', 'college', 'roles', 'route', 'back'));
    }

    public function store(UserRequest $request): RedirectResponse
    {
        if (!in_array($request->role_id, [2,3])) {
            return redirect()
                ->route('college.users.index')
                ->with('warning', 'При обработке запроса произошла ошибка. Пожалуйста, попробуйте ещё раз позже.');
        }
        if ($request->role_id == 2) {
            $request->request->add(['is_director' => 1]);
        }
        if ($request->role_id == 3) {
            $request->merge(['role_id' => 2]);
            $request->request->add(['is_director' => 0]);
        }
        $request->request->add(['password' => Hash::make($request->all()['new-password'])]);
        $request->request->add(['college_id' => auth()->user()->college_id]);
        $user = $this->user->make($request->all());
        $user->refreshRoles($user->role->slug);

        return redirect()
            ->route('college.users.index')
            ->with('success', 'Новый пользователь успешно создан');
    }

    public function update(UserRequest $request, User $user): RedirectResponse
    {
        if (!in_array($request->role_id, [2,3])) {
            return redirect()
                ->route('college.users.index')
                ->with('warning', 'При обработке запроса произошла ошибка. Пожалуйста, попробуйте ещё раз позже.');
        }
        if ($request->role_id == 2) {
            $request->request->add(['is_director' => 1]);
        }
        if ($request->role_id == 3) {
            $request->merge(['role_id' => 2]);
            $request->request->add(['is_director' => 0]);
        }
        $this->user->upgrade($request->all(), $user);
        $user->refreshRoles($user->role->slug);

        return redirect()
            ->route('college.users.index')
            ->with('success', 'Пользователь успешно изменён');
    }

    public function changeStatus(Request $request): JsonResponse
    {
        $user = $this->user->findOrFail($request->id);
        if ($user->isMy()) {
            return response()->json(['error' => 'Нельзя блокировать свою учетную запись.']);
        }
        if ($user->isAdmin()) {
            return response()->json(['error' => 'Нельзя блокировать учетную запись администратора.']);
        }
        $user->changeStatus();

        return response()->json(['success' => 'User status change successfully.']);
    }

    public function password(int $id): Factory|View|Application
    {
        $user = $this->user->findOrFail($id);
        $back = '/college/users';
        $route = 'college.users.password.change';

        return view('auth.passwords.change-password', compact('user', 'back', 'route'));
    }

    public function change(PasswordRequest $request): RedirectResponse
    {
        $user = $this->user->findOrFail($request->get('user_id'));
        $user->password = bcrypt($request->get('new-password'));
        $user->save();

        return redirect($request->get('back'))
            ->with('success', 'Пароль изменен');
    }

    public function login(int $id): RedirectResponse
    {
        $applicants = College::findOrFail(auth()->user()->college_id)->applicants()->pluck('id')->toArray();
        $users = User::whereIn('applicant_id', $applicants)->pluck('id')->toArray();

        if (!in_array($id, array_merge(auth()->user()->colleagues(), $users))) {
            return redirect('/college/applicants')
                ->with('warning', 'Нельзя авторизоваться под этим пользователем');
        }
        Auth::logout();
        Auth::login($this->user->findOrFail($id));

        return redirect(auth()->user()->home());
    }

    public function activity(int $id): Factory|View|Application
    {
        $user = $this->user->findOrFail($id);
        $back = 'college.users.index';

        return view('admin.user.activity', compact('user', 'back'));
    }

    public function snapshot(int $id): Factory|View|Application
    {
        $snapshot = $this->activity->findOrFail($id);
        $back = 'college.users.activity';

        return view('admin.user.snapshot', compact('snapshot', 'back'));
    }

    public function deleteUser(Request $request): JsonResponse
    {
        $user = $this->user->findOrFail($request->id);

        if (Hash::check($request->confirm_password, auth()->user()->password)) {
            if ($user->isMy()) {
                return response()->json(['error' => 'Нельзя удалить свою учетную запись.']);
            }
            if ($user->isAdmin()) {
                return response()->json(['error' => 'Нельзя удалить учетную запись администратора.']);
            }
            $user->delete();
            return response()->json(['success' => 'User has been deleted successfully.']);
        }
        return response()->json(['error' => 'Неверный пароль.']);
    }
}
