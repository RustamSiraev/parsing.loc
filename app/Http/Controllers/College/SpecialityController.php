<?php

namespace App\Http\Controllers\College;

use App\Http\Controllers\AdminController;
use App\Http\Requests\SpecialityRequest;
use App\Models\College;
use App\Models\Speciality;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class SpecialityController extends AdminController
{
    private $speciality;
    private $college;

    public function __construct(
        Speciality $speciality,
        College    $college,
    )
    {
        parent::__construct();
        $this->speciality = $speciality;
        $this->college = $college;
    }

    public function index(): View|Factory|Application
    {
        return view('college.speciality');
    }

    public function getSpecialities(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->college->findOrFail(auth()->user()->college_id)->specialities;
            $data->each(function ($item, $key) {
                $item->educationLevel = $item->educationLevel();
                $item->educationForm = $item->educationForm();
                $item->college = $item->collegeName();
                $item->qualifications = $item->qualificationsList();
                $item->text = $item->status ? 'Заблокировать специальность' : 'Разблокировать специальность';
                $item->icon = $item->status ? 'bi-unlock' : 'bi-lock';
                $item->confirm = $item->status ? 'Вы подтверждаете блокирование?' : 'Вы подтверждаете разблокирование?';
            });
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return '<a class="text-frame" href="/college/specialities/' . $row->id . '/edit" title="Изменить"><i class="bi bi-pencil"></i></a>
                            <a class="text-frame confirm-id" href="#" title="' . $row->text . '" data-bs-toggle="modal" data-bs-target="#dataConfirmModal" data-id="' . $row->id . '" data-confirm="' . $row->confirm . '"><i class="bi ' . $row->icon . '"></i></a>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function create(): Factory|View|Application
    {
        $route = 'college.specialities.store';
        $back = 'college.specialities';

        return view('college.speciality.create', compact('route', 'back'));
    }

    public function edit(int $id): Factory|View|Application
    {
        $speciality = $this->speciality->findOrFail($id);
        $route = 'college.specialities.update';
        $back = 'college.specialities';

        return view('college.speciality.edit', compact('speciality', 'route', 'back'));
    }

    public function store(SpecialityRequest $request): RedirectResponse
    {
        $request->request->add(['college_id' => auth()->user()->college_id]);
        $this->speciality->make($request->all());
        $back = auth()->user()->home() . '/specialities';

        return redirect($back)
            ->with('success', 'Специальность добавлена');
    }

    public function update(SpecialityRequest $request, Speciality $speciality): RedirectResponse
    {
        $this->speciality->upgrade($request->all(), $speciality);
        $back = auth()->user()->home() . '/specialities';

        return redirect($back)
            ->with('success', 'Специальность изменена');
    }

    public function changeStatus(Request $request): JsonResponse
    {
        $speciality = $this->speciality->findOrFail($request->id);

        if (!auth()->user()->isAdmin() && !$speciality->isMy()) {
            return response()->json(['error' => 'Нельзя блокировать эту специалность.']);
        }
        $speciality->changeStatus();

        return response()->json(['success' => 'Speciality status change successfully.']);
    }
}
