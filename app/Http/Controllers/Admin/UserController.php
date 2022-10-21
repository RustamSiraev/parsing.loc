<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use App\Http\Requests\PasswordRequest;
use App\Http\Requests\UserRequest;
use App\Models\Role;
use App\Models\User;
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
    private User $user;
    private Role $role;

    public function __construct(
        User     $user,
        Role     $role,
    )
    {
        parent::__construct();
        $this->user = $user;
        $this->role = $role;
    }

    public function index(): View|Factory|Application
    {
        return view('admin.user.index');
    }

    public function getUsers(Request $request)
    {
        if ($request->ajax())
        {
            $data = $this->user->getAll()->each(function ($item, $key)
            {
                $item->statusValue = $item->getStatusValue();
                $item->text = $item->status ? __('Block user') : __('Unblock user');
                $item->icon = $item->status ? 'bi-unlock' : 'bi-lock';
                $item->checks = $item->parsings->count();
                $item->confirm = $item->status ? __('Do you approve the blocking?') : __('Do you approve unlock?');
            });
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row)
                {
                    if ($row->isAdmin())
                    {
                        return '<a class="text-frame" href="/admin/users/' . $row->id . '/edit" title="' . __("Edit") . '"><i class="bi bi-pencil"></i></a>';
                    }
                    else
                    {
                        return '<a class="text-frame" href="/admin/users/' . $row->id . '/edit" title="' . __("Edit") . '"><i class="bi bi-pencil"></i></a>
                            <a class="text-frame" href="/admin/users/' . $row->id . '/password" title="' . __("Update Password") . '"><i class="bi bi-gear"></i></a>
                            <a class="text-frame confirm-id" href="#" title="' . $row->text . '" data-bs-toggle="modal" data-bs-target="#dataConfirmModal" data-id="' . $row->id . '" data-confirm="' . $row->confirm . '"><i class="bi ' . $row->icon . '"></i></a>
                            <a class="text-frame destroy-id" href="#" title="' . __("Delete Account") . '" data-bs-toggle="modal" data-bs-target="#dataDestroyModal" data-id="' . $row->id . '"><i class="bi bi-person-x"></i></a>';
                    }
                })
                ->addColumn('show', function ($row)
                {
                    return '<a class="decoration-none" href="/admin/users/' . $row->id . '/parsing" title="' . __("Details") . '">' . $row->name . '</a>';
                })
                ->rawColumns(['action', 'show'])
                ->make(true);
        }
    }

    public function parsing(int $id): Factory|View|Application
    {
        $user = $this->user->findOrFail($id);
        $back = 'index';

        return view('admin.user.parsing', compact('user', 'back'));
    }

    public function create(): Factory|View|Application
    {
        $roles = $this->role->getAll();
        $route = 'users.store';
        $back = 'index';

        return view('admin.user.create', compact('roles', 'route', 'back'));
    }

    public function edit(int $id): Factory|View|Application
    {
        $user = $this->user->findOrFail($id);
        $roles = $this->role->getAll();
        $route = 'users.update';
        $back = 'index';

        return view('admin.user.edit', compact('user', 'roles', 'route', 'back'));
    }

    public function store(UserRequest $request): RedirectResponse
    {
        $request->request->add(['password' => Hash::make($request->all()['new-password'])]);
        $user = $this->user->make($request->all());
        $user->refreshRoles($user->role->slug);

        return redirect()
            ->route('index')
            ->with('success', __('New user created successfully'));
    }

    public function update(UserRequest $request, User $user): RedirectResponse
    {
        $this->user->upgrade($request->all(), $user);
        $user->refreshRoles($user->role->slug);

        return redirect()
            ->route('index')
            ->with('success', __('User has been update successfully'));
    }

    public function changeStatus(Request $request): JsonResponse
    {
        $user = $this->user->findOrFail($request->id);

        if ($user->isAdmin())
        {
            return response()->json(['error' => __('You cannot block the administrator account')]);
        }
        $user->changeStatus();

        return response()->json(['success' => __('User status change successfully')]);
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
            ->with('success', __('Password has been update successfully'));
    }

    public function deleteUser(Request $request): JsonResponse
    {
        $user = $this->user->findOrFail($request->id);

        if (Hash::check($request->confirm_password, auth()->user()->password))
        {
            if ($user->isAdmin())
            {
                return response()->json(['error' => __('You cannot delete the administrator account')]);
            }
            $user->delete();
            return response()->json(['success' => 'User has been deleted successfully']);
        }
        return response()->json(['error' => __("The provided password was incorrect.")]);
    }
}
