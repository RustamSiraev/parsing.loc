<?php

namespace App\Http\Controllers\Minobr;

use App\Http\Controllers\AdminController;
use App\Models\Rano;
use App\Models\School;
use App\Models\Statement;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class MinobrController extends AdminController
{
    private $rano;
    private $school;
    private $user;
    private $statement;

    public function __construct(
        User $user,
        Rano $rano,
        School $school,
        Statement $statement,
    )
    {
        parent::__construct();
        $this->user = $user;
        $this->school = $school;
        $this->rano = $rano;
        $this->statement = $statement;
    }

    public function index(): View|Factory|Application
    {
        return view('minobr.index');
    }

    public function statements(): View|Factory|Application
    {
        return view('minobr.index');
    }

    public function getStatements(Request $request)
    {
        if ($request->ajax()) {
            switch (auth()->user()->role_id) {
                case 1:
                case 2:
                case 3:
                    $data = $this->statement->all();
                    break;
                case 5:
                    $data = $this->rano->findOrFail(auth()->user()->rano_id)->statements;
                    break;
            }
            $data->each(function ($item, $key) {
                $item->status = $item->getStatus();
                $item->queue = $item->getQueue();
                $item->lastName = $item->getChild()->l_name;
                $item->firstName = $item->getChild()->f_name;
                $item->middleName = $item->getChild()->m_name;
                $item->schoolName = $item->getSchool()->title;
                $item->created = date('d.m.Y', strtotime($item->created_at));
            });
            return Datatables::of($data)
                ->addIndexColumn()
                ->make(true);
        }
    }

    public function schools(): View|Factory|Application
    {
        return view('minobr.schools');
    }

    public function show(int $id): View|Factory|Application
    {
        $school = School::findOrFail($id);

        return view('minobr.school', compact('school'));
    }

    public function getSchools(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->school->getAll()->each(function ($item, $key) {
                $item->users = $item->getUsers() ?? '0';
                $item->places = $item->getPlaces() ?? '0';
                $item->empty = $item->getPlaces() ?? '0';
                $item->occupancy = $item->getOccupancy().'%';
            });
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('users', function ($row) {
                    return '<a class="text-frame" href="/minobr/schools/' . $row->id . '/users" title="">' . $row->users . '</a>';
                })
                ->addColumn('action', function ($row) {
                    return '<a class="text-frame" href="/minobr/schools/' . $row->id . '" title="Просмотр"><i class="bi bi-eye"></i></a>';
                })
                ->rawColumns(['users', 'action'])
                ->make(true);
        }
    }

    public function ranos(): View|Factory|Application
    {
        return view('minobr.rano');
    }

    public function schoolsList(int $id): View|Factory|Application
    {
        $rano = Rano::findOrFail($id);

        return view('minobr.schools', compact('rano'));
    }

    public function ranoUsersList(int $id): View|Factory|Application
    {
        $rano = Rano::findOrFail($id);

        return view('minobr.user', compact('rano'));
    }

    public function schoolUsersList(int $id): View|Factory|Application
    {
        $school = School::findOrFail($id);

        return view('minobr.user', compact('school'));
    }

    public function getUsers(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->user->getEmployees()->each(function ($item, $key) {
                $item->status = $item->getStatusValue();
            });
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '
                                <a class="text-frame" href="/minobr/users/' . $row->id . '/edit" title="Редактировать"><i class="bi bi-pencil"></i></a>
                                <a class="text-frame" href="/minobr/users/' . $row->id . '/password" title="Изменить пароль"><i class="bi bi-gear"></i></a>
                                <a class="text-frame confirm-id" href="#" title="Блокировка пользователя" data-bs-toggle="modal" data-bs-target="#dataConfirmModal" data-id="' . $row->id . '"><i class="bi bi-lock"></i></a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function getRanos(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->rano->getAll()->each(function ($item, $key) {
                $item->schools = $item->getSchools() ?? '0';
                $item->users = $item->getUsers() ?? '0';
            });
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('schools', function ($row) {
                    return '<a class="text-frame" href="/minobr/ranos/' . $row->id . '/schools" title="">' . $row->schools . '</a>';
                })
                ->addColumn('users', function ($row) {
                    return '<a class="text-frame" href="/minobr/ranos/' . $row->id . '/users" title="">' . $row->users . '</a>';
                })
                ->addColumn('actions', function ($row) {
                    return '<a class="text-frame" href="/minobr/ranos/' . $row->id . '/edit" title="Редактировать"><i class="bi bi-pencil"></i></a>
                            <a class="text-frame confirm-id" href="#" title="Удалить" data-bs-toggle="modal" data-bs-target="#dataConfirmModal" data-id="' . $row->id . '"><i class="bi bi-trash"></i></a>';
                })
                ->rawColumns(['schools', 'users', 'actions'])
                ->make(true);
        }
    }
}
