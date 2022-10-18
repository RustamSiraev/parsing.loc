<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use App\Http\Requests\CollegeRequest;
use App\Models\College;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class CollegeController extends AdminController
{
    private $college;
    private $user;

    public function __construct(
        College $college,
        User $user,
    )
    {
        parent::__construct();
        $this->college = $college;
        $this->user = $user;
    }

    public function index(): View|Factory|Application
    {
        return view('admin.college.index');
    }

    public function getColleges(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->college->getAll()->each(function ($item) {
                $item->statusValue = $item->getStatusValue();
                $item->text = $item->status == 1 ? 'Заблокировать' : 'Разблокировать';
                $item->icon = $item->status == 1 ? 'bi-unlock' : 'bi-lock';
                $array = [
                    1 => 'Вы подтверждаете блокирование?',
                    2 => 'Вы подтверждаете разблокирование?',
                    3 => 'Вы подтверждаете восстановление?',
                    4 => 'Вы подтверждаете удаление?',
                ];
                $item->confirm = $array[$item->status];
            });
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    if ($row->isDeleted()) {
                        return '<a class="text-frame destroy-id" href="#" title="Восстановить" data-bs-toggle="modal" data-bs-target="#dataDeleteModal" data-id="' . $row->id . '" data-confirm="Вы подтверждаете восстановление?">Восстановить</a>';
                    } else {
                        return '
                            <a class="text-frame"  href="/admin/colleges/' . $row->id . '/edit" title="Редактировать"><i class="bi-pencil"></i></a>
                            <a class="text-frame confirm-id" href="#" title="' . $row->text . '" data-bs-toggle="modal" data-bs-target="#dataConfirmModal" data-id="' . $row->id . '" data-confirm="' . $row->confirm . '"><i class="bi ' . $row->icon . '"></i></a>
                            <a class="text-frame destroy-id" href="#" title="Удалить" data-bs-toggle="modal" data-bs-target="#dataDeleteModal" data-id="' . $row->id . '" data-confirm="Вы подтверждаете удаление?"><i class="bi bi-trash"></i></a>';
                    }
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function create(): Factory|View|Application
    {
        $directors = $this->user->directors();

        return view('admin.college.create', compact('directors'));
    }

    public function edit(int $id): Factory|View|Application
    {
        $college = $this->college->findOrFail($id);
        $directors = $this->user->directors();
        $route = 'colleges.update';
        $back = 'colleges.index';

        return view('admin.college.edit', compact('college', 'directors', 'route', 'back'));
    }

    public function store(CollegeRequest $request): RedirectResponse
    {
        $this->college->make($request->all())->refreshDirector();

        return redirect()
            ->route('colleges.index')
            ->with('success', 'СПО добавлен');
    }

    public function update(CollegeRequest $request, College $college): RedirectResponse
    {
        $this->college->upgrade($request->all(), $college);

        $user = User::findOrFail($request->all()['director_id']);
        $user->college_id = $college->id;
        $user->save();

        return redirect()
            ->route('colleges.index')
            ->with('success', 'СПО изменен');
    }

    public function changeStatus(Request $request): JsonResponse
    {
        $this->college->findOrFail($request->id)->changeStatus(1);

        return response()->json(['success' => 'College status change successfully.']);
    }

    public function deleteCollege(Request $request): JsonResponse
    {
        $this->college->findOrFail($request->id)->changeStatus(2);

        return response()->json(['success' => 'College status change successfully.']);
    }
}
