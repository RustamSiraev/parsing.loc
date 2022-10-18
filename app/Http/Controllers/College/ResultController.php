<?php

namespace App\Http\Controllers\College;

use App\Http\Controllers\AdminController;
use App\Http\Requests\SpecialityRequest;
use App\Models\College;
use App\Models\Result;
use App\Models\Speciality;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ResultController extends AdminController
{
    private $speciality;
    private $college;
    private $result;

    public function __construct(
        Speciality $speciality,
        College    $college,
        Result     $result,
    )
    {
        parent::__construct();
        $this->speciality = $speciality;
        $this->college = $college;
        $this->result = $result;
    }

    public function index(): View|Factory|Application
    {
        return view('college.result');
    }

    public function getResults(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->college->findOrFail(auth()->user()->college_id)->results;
            $data->each(function ($item, $key) {
                $speciality = $item->getSpeciality();
                $item->speciality = $speciality->name;
                $item->code = $speciality->code;
                $item->educationLevel = $speciality->educationLevel();
                $item->educationForm = $speciality->educationForm();
            });
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return '<a class="text-frame" href="/college/results/' . $row->id . '/edit" title="Изменить"><i class="bi bi-pencil"></i></a>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function create(int $id): Factory|View|RedirectResponse|Application
    {
        $speciality = $this->speciality->findOrFail($id);
        $testings = $speciality->testings()->where('status', 1)->get();
        $applicants = $speciality->applicants();
        $result = $this->result->where('speciality_id', $id)->first();

        if ($result) {
            return redirect()
                ->route('college.results.edit', ['result' => $result->id]);
        }
        if (count($testings) == 0) {
            return redirect()
                ->route('college.results')
                ->with('warning', 'Сначала заполните испытания этой специальности');
        }
        if (!auth()->user()->isAdmin() && !$testings[0]->isMy()) {
            return redirect()
                ->route('college.results')
                ->with('warning', 'Вы не можете внести результаты испытаний');
        }

        $route = 'college.results.store';
        $back = 'college.results';

        return view('college.result.create', compact('route', 'back', 'testings', 'speciality', 'applicants'));
    }

    public function edit(int $id): Factory|View|Application
    {
        $result = $this->result->findOrFail($id);
        $speciality = $this->speciality->findOrFail($result->speciality_id);
        $testings = $speciality->testings()->where('status', 1)->get();
        $applicants = $speciality->applicants();
        $data = json_decode(json_decode($result, true)['data'], true);

        $route = 'college.results.update';
        $back = 'college.results';

        return view('college.result.edit', compact('route', 'back', 'testings', 'speciality', 'applicants', 'result', 'data'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->request->add(['user_id' => auth()->user()->id]);
        $request->request->add(['speciality_id' => $request->speciality_id]);

        $back = auth()->user()->home() . '/results';

        if ($request->date && $request->grade) {
            $data['date'] = $request->date;
            $data['grade'] = $request->grade;
            $request->request->add(['data' => json_encode($data)]);
            foreach ($data['grade'] as $key=>$item) {
                $arr[] = $key;
            }
            $request->request->add(['ids' => implode(',',$arr)]);
            $this->result->create($request->all());

            return redirect($back)
                ->with('success', 'Результаты испытаний добавлены');
        }
        return redirect($back)
            ->with('warning', 'Результаты испытаний не добавлены');
    }

    public function update(Request $request, Result $result): RedirectResponse
    {
        $data['date'] = $request->date;
        $data['grade'] = $request->grade;
        $request->request->add(['data' => json_encode($data)]);
        foreach ($data['grade'] as $key=>$item) {
            $arr[] = $key;
        }
        $request->request->add(['ids' => implode(',',$arr)]);
        $result->update([
            'data' => json_encode($data),
            'ids' => implode(',',$arr),
        ]);

        $back = auth()->user()->home() . '/results';

        return redirect($back)
            ->with('success', 'Результаты испытаний изменены');
    }
}
