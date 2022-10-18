<?php

namespace App\Http\Controllers\College;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Controller;
use App\Models\College;
use App\Models\Qualification;
use App\Models\Speciality;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class QualificationController extends AdminController
{
    private $speciality;
    private $college;
    private $qualification;

    public function __construct(
        Speciality    $speciality,
        College       $college,
        Qualification $qualification,
    )
    {
        parent::__construct();
        $this->speciality = $speciality;
        $this->college = $college;
        $this->qualification = $qualification;
    }

    public function getQualifications(Request $request, int $speciality)
    {
        if ($request->ajax()) {
            $data = $this->speciality->findOrFail($speciality)->qualifications;
            $data->each(function ($item, $key) {
                $item->text = $item->status ? 'Заблокировать квалификацию' : 'Разблокировать квалификацию';
                $item->icon = $item->status ? 'bi-unlock' : 'bi-lock';
                $item->confirm = $item->status ? 'Вы подтверждаете блокирование?' : 'Вы подтверждаете разблокирование?';
                $item->status = $item->statusValue();
            });
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return '<a class="text-frame qualification" href="#" title="Изменить квалификацию" data-name="' . $row->name . '" data-id="' . $row->id . '" data-route="qualification-edit" data-bs-toggle="modal" data-bs-target="#dataQualificationModal" data-text="Редактирование квалификации"><i class="bi bi-pencil"></i></a>
                            <a class="text-frame confirm-id" href="#" data-route="qualification-change" title="' . $row->text . '" data-bs-toggle="modal" data-bs-target="#dataConfirmModal" data-id="' . $row->id . '" data-confirm="' . $row->confirm . '"><i class="bi ' . $row->icon . '"></i></a>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function changeStatus(Request $request): JsonResponse
    {
        $qualification = $this->qualification->findOrFail($request->id);

        if (!auth()->user()->isAdmin() && !$qualification->isMy()) {
            return response()->json(['error' => 'Нельзя блокировать эту специалность.']);
        }
        $qualification->changeStatus();

        return response()->json(['success' => 'Speciality status change successfully.']);
    }

    public function addQualification(Request $request): JsonResponse
    {
        $qualification = $this->qualification->where('name', $request->name)->first();
        if ($qualification) {
            $data['error'] = 'Такая квалификация уже существует.';
        } elseif (!auth()->user()->isAdmin() && !$this->speciality->findOrFail($request->speciality)->isMy()) {
            $data['error'] = 'Вы не можете добавить квалификацию в эту специалность.';
        } else {
            $data = $this->qualification->create([
                'name' => $request->name,
                'speciality_id' => $request->speciality,
            ]);
        }

        return response()->json($data);
    }

    public function editQualification(Request $request): JsonResponse
    {
        $qualification = $this->qualification->findOrFail($request->id);

        if (!auth()->user()->isAdmin() && !$qualification->isMy()) {
            $data['error'] = 'Вы не можете добавить квалификацию в эту специалность.';
        } else {
            $oldQualification = $this->qualification->where('name', $request->name)->first();
            if ($oldQualification && $oldQualification->id != $qualification->id) {
                $data['error'] = 'Такая квалификация уже существует.';
            } else {
                $qualification->update([
                    'name' => $request->name,
                ]);
                $data['success'] = 'success';
            }
        }
        return response()->json($data);
    }
}
