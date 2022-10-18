<?php

namespace App\Http\Controllers\Applicant;

use App\Http\Controllers\AdminController;
use App\Http\Requests\StatementRequest;
use App\Models\Applicant;
use App\Models\College;
use App\Models\Statement;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class StatementController extends AdminController
{
    private $statement;
    private $applicant;
    private $college;

    public function __construct(
        Statement $statement,
        Applicant $applicant,
        College $college,
    )
    {
        parent::__construct();
        $this->statement = $statement;
        $this->applicant = $applicant;
        $this->college = $college;
    }

    public function index(): View|Factory|Application
    {
        return view('applicant.statements.index');
    }

    public function getStatement(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->applicant->findOrFail(auth()->user()->applicant_id)->statements->each(function ($item, $key) {
                $item->college = $item->getCollege()->title;
                $item->code = $item->getSpeciality()->code;
                $item->speciality = $item->getSpeciality()->name;
                $item->qualifications = $item->getSpeciality()->qualificationsList();
                $item->educationForm = $item->getSpeciality()->educationForm();
                $item->educationTime = $item->getSpeciality()->education_time;
                $item->statusValue = $item->getStatus();
            });
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    if ($row->status_id == 1) {
                        $actionBtn = '<a class="text-frame confirm-id" href="#" data-route="statement-delete" title="Удалить" data-bs-toggle="modal" data-confirm="Вы подтверждате удаление" data-bs-target="#dataConfirmModal" data-id="' . $row->id . '"><i class="bi bi-trash"></i></a>';
                    } elseif ($row->status_id == 4) {
                        $actionBtn = '<a class="text-frame message-modal" href="#" title="Посмотреть сообщение" data-bs-toggle="modal" data-bs-target="#dataMessageModal" data-id="' . $row->id . '"><i class="bi bi-eye"></i></a>
                                    <a class="text-frame confirm-id" href="#" data-route="statement-delete" title="Удалить" data-bs-toggle="modal" data-confirm="Вы подтверждате удаление" data-bs-target="#dataConfirmModal" data-id="' . $row->id . '"><i class="bi bi-trash"></i></a>';
                    } else {
                        $actionBtn = '';
                    }
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function create(): Factory|View|Application
    {
        $alerts = [];
        $colleges = $this->college->getAllActive();
        $diploma = $this->applicant->findOrFail(auth()->user()->applicant_id)->getDiploma();

        for ($i=1;$i<14;$i++) {
            $documents[] = auth()->user()->applicant->documents($i);
        }

        if (!$diploma) $alerts[] = 'Аттестат';
        if ($documents) {
            if (!$documents[0]) $alerts[] = 'Фотография';
            if (!$documents[1]) $alerts[] = 'Документ, удостоверяющий личность';
            if (!$documents[4]) $alerts[] = 'Документ об образовании';
            if (!$documents[7]) $alerts[] = 'Медицинская справка';
        }

        return view('applicant.statements.create', compact('colleges', 'alerts', 'diploma'));
    }

    public function store(StatementRequest $request): RedirectResponse
    {
        $request->request->add(['applicant_id' => auth()->user()->applicant_id]);
        $request->request->add(['user_id' => auth()->user()->id]);

        $this->statement->make($request->all());

        return redirect()
            ->route('applicant.statement.index')
            ->with('success', 'Заявление успешно подано');
    }

    public function educationForm(Request $request): JsonResponse
    {
        $college = $this->college->findOrFail($request->id);

        if ($college->educationForm()) {
            $data = $college->educationForm();
        } else {
            $data['error'] = '<span class="invalid" role="alert">
                                <strong>Образовательная организация не осуществляет прием</strong>
                            </span>';
        }

        return response()->json($data);
    }

    public function speciality(Request $request): JsonResponse
    {
        $college = $this->college->findOrFail($request->id);

        if ($college->activeSpecialities([$request->form])) {
            $data = $college->activeSpecialities([$request->form]);
        } else {
            $data['error'] = '<span class="invalid" role="alert">
                                <strong>Нет специальностей по этой форме обучения</strong>
                            </span>';
        }

        return response()->json($data);
    }

    public function delete(Request $request): JsonResponse
    {
        $statement = $this->statement->findOrFail($request->id);

        if (!$statement->isMy() || !in_array($statement->status_id, [1,4])) {
            return response()->json(['error' => 'Нельзя удалить заявление.']);
        }
        $statement->delete();

        return response()->json(['success' => 'deleted successfully']);
    }

    public function message(Request $request): JsonResponse
    {
        $statement = $this->statement->findOrFail($request->id);

        if (!$statement->isMy() || $statement->status_id != 4) {
            return response()->json(['error' => 'Нет сообщений.']);
        }

        return response()->json($statement->message);
    }
}
