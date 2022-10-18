<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use App\Http\Requests\ApplicantRequest;
use App\Http\Requests\SignupRequest;
use App\Models\Activity;
use App\Models\Applicant;
use App\Models\User;
use Hash;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class ApplicantController extends AdminController
{
    private $applicant;
    private $user;
    private $activity;

    public function __construct(
        Applicant $applicant,
        User $user,
        Activity $activity,
    )
    {
        parent::__construct();
        $this->applicant = $applicant;
        $this->user = $user;
        $this->activity = $activity;
    }

    public function index(): View|Factory|Application
    {
        return view('admin.applicant.index');
    }

    public function getApplicant(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->applicant->getAll()->each(function ($item) {
                $item->birth_day = $item->born_at ? date('d.m.Y', strtotime($item->born_at)) : '';
                $item->statusValue = $item->getStatusValue();
                $item->doc_type = $item->getDocType();
                $item->text = $item->status ? 'Заблокировать' : 'Разблокировать';
                $item->icon = $item->status ? 'bi-unlock' : 'bi-lock';
                $item->confirm = $item->status ? 'Вы подтверждаете блокирование?' : 'Вы подтверждаете разблокирование?';
            });
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return '
                            <a class="text-frame" href="/admin/applicants/' . $row->getUser()->id . '/activity" title="История действий"><i class="bi bi-camera"></i></a>
                            <a class="text-frame" href="/admin/applicants/' . $row->id . '" title="Посмотреть"><i class="bi bi-eye"></i></a>
                            <a class="text-frame" href="/admin/applicants/' . $row->id . '/edit" title="Редактировать"><i class="bi bi-pencil"></i></a>
                            <a class="text-frame" href="/admin/applicants/' . $row->id . '/password" title="Изменить пароль"><i class="bi bi-gear"></i></a>
                            <a class="text-frame confirm-id" href="#" title="' . $row->text . '" data-bs-toggle="modal" data-bs-target="#dataConfirmModal" data-id="' . $row->id . '" data-confirm="' . $row->confirm . '"><i class="bi ' . $row->icon . '"></i></a>
                            <a class="text-frame" href="/admin/users/' . $row->getUser()->id . '/login" title="Зайти под абитуриентом"><i class="bi bi-box-arrow-in-right"></i></a>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function changeApplicant(Request $request): JsonResponse
    {
        $this->applicant->findOrFail($request->id)->changeStatus();

        return response()->json(['success' => 'Applicant status change successfully.']);
    }

    public function show(int $id): Factory|View|Application
    {
        $applicant = $this->applicant->findOrFail($id);
        $diploma = $applicant->getDiploma();
        $grades = $diploma ? json_decode($diploma->data, true) : '';
        for ($i=1;$i<14;$i++) {
            $documents[] = $applicant->documents($i);
        }
        $back = 'applicants.index';

        return view('admin.applicant.show', compact('applicant', 'back', 'grades', 'diploma', 'documents'));
    }

    public function activity(int $id): Factory|View|Application
    {
        $user = $this->user->findOrFail($id);
        $back = 'applicants.index';

        return view('admin.user.activity', compact('user', 'back'));
    }

    public function snapshot(int $id): Factory|View|Application
    {
        $snapshot = $this->activity->findOrFail($id);
        $back = 'applicants.activity';

        return view('admin.user.snapshot', compact('snapshot', 'back'));
    }

    public function create(): Factory|View|Application
    {
        $back = 'applicants.index';
        $route = 'applicants.store';

        return view('admin.applicant.create', compact('back', 'route'));
    }

    public function edit(int $id): Factory|View|Application
    {
        $applicant = $this->applicant->findOrFail($id);
        $back = 'applicants.index';
        $route = 'applicants.update';

        return view('admin.applicant.edit', compact('applicant', 'back', 'route'));
    }

    public function store(ApplicantRequest $request): RedirectResponse
    {
        $applicant = Applicant::create($request->all());

        $fullName = $request->l_name . ' ' . $request->f_name;
        if ($request->m_name != '') $fullName .= ' ' . $request->m_name;

        $user = User::create([
            'name' => $fullName,
            'email' => $request->email,
            'phone' => $request->phone,
            'role_id' => 4,
            'applicant_id' => $applicant->id,
            'remember_token' => Str::random(10),
            'password' => Hash::make($request->all()['new-password']),
        ]);

        $user->refreshRoles($user->role->slug);
        return redirect()
            ->route('applicants.index')
            ->with('success', 'Абитуриент успешно добавлен');
    }

    public function update(ApplicantRequest $request, Applicant $applicant): RedirectResponse
    {
        $applicant->update($request->all());

        $fullName = $request->l_name . ' ' . $request->f_name;
        if ($request->m_name != '') $fullName .= ' ' . $request->m_name;

        $this->user->where('applicant_id', $applicant->id)->firstOrFail()->update([
            'name' => $fullName,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        return redirect()
            ->route('applicants.index')
            ->with('success', 'Абитуриент успешно изменен');
    }

    public function password(int $id): Factory|View|Application
    {
        $user = $this->applicant->findOrFail($id)->getUser();
        $back = '/admin/applicants';
        $route = 'users.password.change';

        return view('auth.passwords.change-password', compact('user', 'back', 'route'));
    }
}
