<?php

namespace App\Http\Controllers\Rano;

use App\Http\Controllers\AdminController;
use App\Http\Requests\PasswordRequest;
use App\Http\Requests\CollegeRequest;
use App\Http\Requests\UserRequest;
use App\Models\Rano;
use App\Models\School;
use App\Models\User;
use Hash;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class RanoController extends AdminController
{
    private $rano;
    private $school;
    private $user;

    public function __construct(
        User $user,
        Rano $rano,
        School $school,
    )
    {
        parent::__construct();
        $this->user = $user;
        $this->school = $school;
        $this->rano = $rano;
    }

    public function index(): View|Factory|Application
    {
        return view('rano.index');
    }

    public function statements(): View|Factory|Application
    {
        return view('rano.index');
    }

    public function schools(): View|Factory|Application
    {
        return view('rano.schools');
    }

    public function show(int $id): View|Factory|Application
    {
        $school = School::findOrFail($id);

        return view('rano.school', compact('school'));
    }

    public function getSchools(Request $request)
    {
        if ($request->ajax()) {
            $rano = Rano::findOrFail(auth()->user()->rano_id);
            $data = $rano->schools->each(function ($item, $key) {
                $item->users = $item->getUsers() ?? '0';
                $item->places = $item->getPlaces() ?? '0';
                $item->empty = $item->getPlaces() ?? '0';
                $item->occupancy = $item->getOccupancy().'%';
            });
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('users', function ($row) {
                    return '<a class="text-frame" href="/rano/schools/' . $row->id . '/users" title="">' . $row->users . '</a>';
                })
                ->addColumn('action', function ($row) {
                    return '<a class="text-frame" href="/rano/schools/' . $row->id . '/edit" title="Просмотр"><i class="bi bi-pencil"></i></a>';
                })
                ->rawColumns(['users', 'action'])
                ->make(true);
        }
    }

    public function schoolUsersList(int $id): View|Factory|Application
    {
        $school = School::findOrFail($id);

        return view('rano.user', compact('school'));
    }

    public function getUsers(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->user->getEmployees()->each(function ($item, $key) {
                $item->status = $item->getStatusValue();
            });
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '
                                <a class="text-frame" href="/rano/schools/users/' . $row->id . '/edit" title="Редактировать"><i class="bi bi-pencil"></i></a>
                                <a class="text-frame" href="/rano/schools/users/' . $row->id . '/password" title="Изменить пароль"><i class="bi bi-gear"></i></a>
                                <a class="text-frame confirm-id" href="#" title="Блокировка пользователя" data-bs-toggle="modal" data-bs-target="#dataConfirmModal" data-id="' . $row->id . '"><i class="bi bi-lock"></i></a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function createUser(Request $request): Factory|View|Application
    {
        $school = $this->school->findOrFail($request->query('school'));

        return view('rano.user.create', compact('school'));
    }

    public function editUser(int $id): Factory|View|Application
    {
        $user = User::findOrFail($id);
        $school = $this->school->findOrFail($user->school_id);

        return view('rano.user.edit', compact('user', 'school'));
    }

    public function storeUser(UserRequest $request): RedirectResponse
    {
        $request->request->add(['password' => Hash::make(Str::random(10))]);
        $user = $this->user->make($request->all());

        return redirect()
            ->route('schools.users', ['school' => $user->school_id])
            ->with('success', 'Новый пользователь успешно создан');
    }

    public function updateUser(UserRequest $request, User $user): RedirectResponse
    {
        $this->user->upgrade($request->all(), $user);

        return redirect()
            ->route('schools.users', ['school' => $user->school_id])
            ->with('success', 'Пользователь успешно изменён');
    }

    public function create(): Factory|View|Application
    {
        return view('rano.school.create');
    }

    public function edit(int $id): Factory|View|Application
    {
        $school = School::findOrFail($id);

        return view('rano.school.edit', compact('school'));
    }

    public function store(CollegeRequest $request): RedirectResponse
    {
        $request->request->add(['rano_id' => auth()->user()->rano_id]);
        $school = $this->school->make($request->all());

        return redirect()
            ->route('rano.schools', compact('school'))
            ->with('success', 'Новая школа добавлена');
    }

    public function update(CollegeRequest $request, School $school): RedirectResponse
    {
        $this->school->upgrade($request->all(), $school);

        return redirect()
            ->route('rano.schools', compact('school'))
            ->with('success', 'Школа успешно изменена');
    }

    public function password(int $id): Factory|View|Application
    {
        $user = User::findOrFail($id);
        $back = '/rano/schools/'.$user->school_id.'/users';

        return view('auth.passwords.change-password', compact('user', 'back'));
    }
}
