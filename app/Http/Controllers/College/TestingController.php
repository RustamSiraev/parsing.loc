<?php

namespace App\Http\Controllers\College;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Controller;
use App\Models\College;
use App\Models\Qualification;
use App\Models\Speciality;
use App\Models\Testing;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class TestingController extends AdminController
{
    private $speciality;
    private $college;
    private $qualification;

    public function __construct(
        Speciality $speciality,
        College    $college,
        Testing    $testing,
    )
    {
        parent::__construct();
        $this->speciality = $speciality;
        $this->college = $college;
        $this->testing = $testing;
    }

    public function getTestings(Request $request, int $speciality)
    {
        if ($request->ajax()) {
            $data = $this->speciality->findOrFail($speciality)->testings;
            $data->each(function ($item, $key) {
                $item->text = $item->status ? 'Заблокировать испытание' : 'Разблокировать испытание';
                $item->icon = $item->status ? 'bi-unlock' : 'bi-lock';
                $item->confirm = $item->status ? 'Вы подтверждаете блокирование?' : 'Вы подтверждаете разблокирование?';
                $item->status = $item->statusValue();
                $item->gradeValue = $item->gradeValue();
            });
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return '<a class="text-frame testing" href="#" title="Изменить испытание" data-name="' . $row->name . '" data-grade="' . $row->grade . '" data-id="' . $row->id . '" data-route="testing-edit" data-bs-toggle="modal" data-bs-target="#dataTestingModal" data-text="Редактирование испытания"><i class="bi bi-pencil"></i></a>
                            <a class="text-frame confirm-id" href="#" data-route="testing-change" title="' . $row->text . '" data-bs-toggle="modal" data-bs-target="#dataConfirmModal" data-id="' . $row->id . '" data-confirm="' . $row->confirm . '"><i class="bi ' . $row->icon . '"></i></a>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function changeStatus(Request $request): JsonResponse
    {
        $testing = $this->testing->findOrFail($request->id);

        if (!auth()->user()->isAdmin() && !$testing->isMy()) {
            return response()->json(['error' => 'Нельзя блокировать эту специалность.']);
        }
        $testing->changeStatus();

        return response()->json(['success' => 'Testing status change successfully.']);
    }

    public function addTesting(Request $request): JsonResponse
    {
        if (!auth()->user()->isAdmin() && !$this->speciality->findOrFail($request->speciality)->isMy()) {
            $data['error'] = 'Вы не можете добавить испытание в эту специалность.';
        } elseif (!in_array($request->grade, [1,2,3,4])) {
            $data['error'] = 'При обработке запроса произошла ошибка. Попробуйте позже.';
        } else {
            $data = $this->testing->create([
                'name' => $request->name,
                'grade' => $request->grade,
                'speciality_id' => $request->speciality,
            ]);
        }

        return response()->json($data);
    }

    public function editTesting(Request $request): JsonResponse
    {
        $testing = $this->testing->findOrFail($request->id);

        if (!auth()->user()->isAdmin() && !$testing->isMy()) {
            $data['error'] = 'Вы не можете добавить испытание в эту специалность.';
        } elseif (!in_array($request->grade, [1,2,3,4])) {
            $data['error'] = 'При обработке запроса произошла ошибка. Попробуйте позже.';
        } else {
            $testing->update([
                'name' => $request->name,
                'grade' => $request->grade,
            ]);
            $data['success'] = 'success';
        }

        return response()->json($data);
    }
}
