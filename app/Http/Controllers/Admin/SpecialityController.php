<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use App\Models\Speciality;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class SpecialityController extends AdminController
{
    private $speciality;

    public function __construct(
        Speciality $speciality,
    )
    {
        parent::__construct();
        $this->speciality = $speciality;
    }

    public function index(): View|Factory|Application
    {
        return view('college.speciality');
    }

    public function getSpecialities(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->speciality->all();
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
                    return '<a class="text-frame confirm-id" href="#" title="' . $row->text . '" data-bs-toggle="modal" data-bs-target="#dataConfirmModal" data-id="' . $row->id . '" data-confirm="' . $row->confirm . '"><i class="bi ' . $row->icon . '"></i></a>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }
}
