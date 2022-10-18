<?php

namespace App\Http\Controllers\College;

use App\Http\Controllers\AdminController;
use App\Http\Requests\CollegeRequest;
use App\Models\College;
use App\Models\News;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class CollegeController extends AdminController
{
    private $user;
    private $news;
    private $college;

    public function __construct(
        User $user,
        News $news,
        College $college,
    )
    {
        parent::__construct();
        $this->user = $user;
        $this->news = $news;
        $this->college = $college;
    }

    public function index(): View|Factory|Application
    {
        $news = $this->news->getAll();

        return view('college.index', compact('news'));
    }

    public function statements(): View|Factory|Application
    {
        return view('college.statement');
    }

    public function getStatements(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->college->findOrFail(auth()->user()->college_id)->statements;
            $data->each(function ($item, $key) {
                $speciality = $item->getSpeciality();
                $applicant = $item->getApplicant();
                $item->code = $speciality->code;
                $item->speciality = $speciality->name;
                $item->educationLevel = $speciality->educationLevel();
                $item->statusValue = $item->getStatus();
                $item->l_name = $applicant->l_name;
                $item->f_name = $applicant->f_name;
                $item->m_name = $applicant->m_name;
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

    public function edit(): Factory|View|Application
    {
        $college = $this->college->findOrFail(auth()->user()->college_id);
        $directors = $this->user->directors();
        $route = 'college.update';

        return view('admin.college.edit', compact('college', 'directors', 'route'));
    }

    public function update(CollegeRequest $request, College $college): RedirectResponse
    {
        $this->college->upgrade($request->all(), $college);

        $user = User::findOrFail($request->all()['director_id']);
        $user->college_id = $college->id;
        $user->save();

        return redirect()
            ->route('college.edit')
            ->with('success', 'Данные успешно изменены');
    }
}
