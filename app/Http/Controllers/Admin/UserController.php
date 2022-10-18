<?php

namespace App\Http\Controllers\Admin;

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
        User     $user,
        Role     $role,
        News     $news,
        College  $college,
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
        return view('admin.user.index');
    }

    public function getUsers(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->user->getEmployees()->each(function ($item, $key) {
                $item->role_id = $item->getRole();
                $item->statusValue = $item->getStatusValue();
                $item->college = $item->getCollege();
                $item->text = $item->status ? 'Заблокировать пользователя' : 'Разблокировать пользователя';
                $item->icon = $item->status ? 'bi-unlock' : 'bi-lock';
                $item->confirm = $item->status ? 'Вы подтверждаете блокирование?' : 'Вы подтверждаете разблокирование?';
            });
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    if ($row->isAdmin()) {
                        return '<a class="text-frame" href="/admin/users/' . $row->id . '/activity" title="История действий"><i class="bi bi-camera"></i></a>
                                <a class="text-frame" href="/admin/users/' . $row->id . '/edit" title="Редактировать"><i class="bi bi-pencil"></i></a>';
                    } else {
                        return '<a class="text-frame" href="/admin/users/' . $row->id . '/activity" title="История действий"><i class="bi bi-camera"></i></a>
                            <a class="text-frame" href="/admin/users/' . $row->id . '/edit" title="Редактировать"><i class="bi bi-pencil"></i></a>
                            <a class="text-frame" href="/admin/users/' . $row->id . '/password" title="Изменить пароль"><i class="bi bi-gear"></i></a>
                            <a class="text-frame confirm-id" href="#" title="' . $row->text . '" data-bs-toggle="modal" data-bs-target="#dataConfirmModal" data-id="' . $row->id . '" data-confirm="' . $row->confirm . '"><i class="bi ' . $row->icon . '"></i></a>
                            <a class="text-frame destroy-id" href="#" title="Удалить пользователя" data-bs-toggle="modal" data-bs-target="#dataDestroyModal" data-id="' . $row->id . '"><i class="bi bi-person-x"></i></a>
                            <a class="text-frame" href="/admin/users/' . $row->id . '/login" title="Зайти под пользователем"><i class="bi bi-box-arrow-in-right"></i></a>';
                    }
                })
                ->addColumn('show', function ($row) {
                    return '<a class="decoration-none" href="/admin/users/' . $row->id . '/show" title="Посмотреть">' . $row->name . '</a>';
                })
                ->rawColumns(['action', 'show'])
                ->make(true);
        }
    }

    public function show(int $id): Factory|View|Application
    {
        $user = $this->user->findOrFail($id);
        $back = 'users.index';

        return view('admin.user.show', compact('user', 'back'));
    }

    public function create(): Factory|View|Application
    {
        $roles = $this->role->getEmployees();
        $college = $this->college->getAll();
        $route = 'users.store';
        $back = 'users.index';

        return view('admin.user.create', compact('roles', 'college', 'route', 'back'));
    }

    public function edit(int $id): Factory|View|Application
    {
        $user = $this->user->findOrFail($id);
        $roles = $this->role->getEmployees();
        $college = $this->college->getAll();
        $route = 'users.update';
        $back = 'users.index';

        return view('admin.user.edit', compact('user', 'college', 'roles', 'route', 'back'));
    }

    public function store(UserRequest $request): RedirectResponse
    {
        $request->request->add(['password' => Hash::make($request->all()['new-password'])]);
        if ($request->role_id == 2) {
            $request->request->add(['is_director' => 1]);
        }
        if ($request->role_id == 3) {
            $request->merge(['role_id' => 2]);
            $request->request->add(['is_director' => 0]);
        }
        $user = $this->user->make($request->all());
        $user->refreshRoles($user->role->slug);

        return redirect()
            ->route('users.index')
            ->with('success', 'Новый пользователь успешно создан');
    }

    public function update(UserRequest $request, User $user): RedirectResponse
    {
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
            ->route('users.index')
            ->with('success', 'Пользователь успешно изменён');
    }

    public function changeStatus(Request $request): JsonResponse
    {
        $user = $this->user->findOrFail($request->id);

        if ($user->isAdmin()) {
            return response()->json(['error' => 'Нельзя блокировать учетную запись администратора.']);
        }
        $user->changeStatus();

        return response()->json(['success' => 'User status change successfully.']);
    }

    public function password(int $id): Factory|View|Application
    {
        $user = $this->user->findOrFail($id);
        $back = '/admin/users';
        $route = 'users.password.change';

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
        Auth::logout();
        Auth::login($this->user->findOrFail($id));

        return redirect(auth()->user()->home());
    }

    public function activity(int $id): Factory|View|Application
    {
        $user = $this->user->findOrFail($id);
        $back = 'users.index';

        return view('admin.user.activity', compact('user', 'back'));
    }

    public function getActivity(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->activity->getAll()->each(function ($item, $key) {
                $item->type = $item->getType();
                $item->table = $item->getModel();
            });
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    if (auth()->user()->isAdmin()) {
                        if ($row->user->role_id == 4) {
                            return '<a class="text-frame" href="/admin/applicants/' . $row->id . '/snapshot" title="Подробнее"><i class="bi bi-eye"></i></a>';
                        } else {
                            return '<a class="text-frame" href="/admin/users/' . $row->id . '/snapshot" title="Подробнее"><i class="bi bi-eye"></i></a>';
                        }
                    } else {
                        if ($row->user->role_id == 4) {
                            return '<a class="text-frame" href="/college/applicants/' . $row->id . '/snapshot" title="Подробнее"><i class="bi bi-eye"></i></a>';
                        } else {
                            return '<a class="text-frame" href="/college/users/' . $row->id . '/snapshot" title="Подробнее"><i class="bi bi-eye"></i></a>';
                        }
                    }
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function snapshot(int $id): Factory|View|Application
    {
        $snapshot = $this->activity->findOrFail($id);
        $back = 'users.activity';

        return view('admin.user.snapshot', compact('snapshot', 'back'));
    }

    public function deleteUser(Request $request): JsonResponse
    {
        $user = $this->user->findOrFail($request->id);

        if (Hash::check($request->confirm_password, auth()->user()->password)) {
            if ($user->isAdmin()) {
                return response()->json(['error' => 'Нельзя удалить учетную запись администратора.']);
            }
            if ($user->isActivity()) {
                return response()->json(['error' => 'Нельзя удалить учетную запись.']);
            }
            $user->delete();
            return response()->json(['success' => 'User has been deleted successfully.']);
        }
        return response()->json(['error' => 'Неверный пароль.']);
    }
}
