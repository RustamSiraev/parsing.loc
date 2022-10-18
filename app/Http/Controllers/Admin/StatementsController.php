<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use App\Models\Statement;
use App\Models\Testing;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class StatementsController extends AdminController
{
    private $statement;

    public function __construct(
        Statement $statement,
    )
    {
        parent::__construct();
        $this->statement = $statement;
    }
    public function index(): View|Factory|Application
    {
        return view('admin.college.statement');
    }

    public function getStatements(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->statement->all();
            $data->each(function ($item, $key) {
                $speciality = $item->getSpeciality();
                $applicant = $item->getApplicant();
                $item->college = $speciality->collegeName();
                $item->code = $speciality->code;
                $item->speciality = $speciality->name;
                $item->educationLevel = $speciality->educationLevel();
                $item->statusValue = $item->getStatus();
                $item->applicant = $applicant->getFullName();
                $item->average = $applicant->getDiploma()->average ?? '-';
                $item->created = date('d.m.Y', strtotime($item->created_at));
                $item->results = $item->resultsList();
            });
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $action = '';
                    if ($row->target) {
                        $action .= '<span class="text-frame status-list" title="Целевой прием">Целевой прием</span><br>';
                    }
                    if ($row->benefit) {
                        $action .= '<span class="text-frame status-list" title="Есть льготы">Есть льготы</span><br>';
                    }
                    if ($row->limited) {
                        $action .= '<span class="text-frame status-list" title="Наличие ОВЗ">Наличие ОВЗ</span><br>';
                    }
                    if ($row->disabled) {
                        $action .= '<span class="text-frame status-list" title="Инвалидность">Инвалидность</span><br>';
                    }
                    return $action;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }
}
