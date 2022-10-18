<?php

namespace App\Http\Controllers\College;

use App\Http\Controllers\AdminController;
use App\Http\Requests\ApplicantRequest;
use App\Models\Applicant;
use App\Models\College;
use App\Models\Statement;
use App\Models\Testing;
use App\Models\User;
use Hash;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class StatementController extends AdminController
{
    private $statement;

    public function __construct(
        Statement $statement,
    )
    {
        parent::__construct();
        $this->statement = $statement;
    }

    public function show(int $id): Factory|View|Application
    {
        $statement = $this->statement->findOrFail($id);
        $applicant = $statement->getApplicant();
        $diploma = $applicant->getDiploma();
        $result = json_decode($statement->getSpeciality()->getResult(), true);
        $grades = $diploma ? json_decode($diploma->data, true) : '';
        $data = [];
        if ($result && in_array($applicant->id, explode(',', $statement->getSpeciality()->getResult()->ids))) {
            $data = $result ? json_decode($result['data'], true)['grade'][$applicant->id] : '';
            $arr = [];
            foreach (json_decode($result['data'], true)['date'] as $key=>$item) {
                $arr[$key]['testing'] = Testing::findOrFail($key)->name;
                $arr[$key]['grade'] = Testing::findOrFail($key)->gradeValue();
                $arr[$key]['date'] = date('d.m.Y ', strtotime($item)) ?? '';
                $arr[$key]['res'] = $data[$key];
            }
            $data = $arr;
        }
        for ($i = 1; $i < 14; $i++) {
            $documents[] = $applicant->documents($i);
        }
        $back = 'college.statements';

        return view('college.statement.show', compact('statement', 'applicant', 'back', 'grades', 'diploma', 'documents', 'data'));
    }

    public function create(): Factory|View|Application
    {
        $back = 'college.statements';
        $route = 'college.statements.store';

        return view('college.statement.create', compact('back', 'route'));
    }

    public function edit(int $id): Factory|View|Application
    {
        $statement = $this->statement->findOrFail($id);
        $back = 'college.statements';
        $route = 'college.statements.update';

        return view('college.statement.edit', compact('statement', 'back', 'route'));
    }

    public function store(ApplicantRequest $request): RedirectResponse
    {
        $applicant = Applicant::create($request->all());

        $fullName = $request->l_name . ' ' . $request->f_name;
        if ($request->m_name != '') $fullName .= ' ' . $request->m_name;

        $user = User::create([
            'name' => $fullName,
            'email' => $request->email,
            'phone' => $request->phone,
            'role_id' => 4,
            'applicant_id' => $applicant->id,
            'remember_token' => Str::random(10),
            'password' => Hash::make($request->all()['new-password']),
        ]);

        $user->refreshRoles($user->role->slug);
        return redirect()
            ->route('college.statements')
            ->with('success', 'Заявление успешно добавлено');
    }

    public function update(ApplicantRequest $request, Applicant $applicant): RedirectResponse
    {
        $applicant->update($request->all());

        $fullName = $request->l_name . ' ' . $request->f_name;
        if ($request->m_name != '') $fullName .= ' ' . $request->m_name;

        $this->user->where('applicant_id', $applicant->id)->firstOrFail()->update([
            'name' => $fullName,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        return redirect()
            ->route('college.statements')
            ->with('success', 'Заявление успешно изменено');
    }

    public function accept(int $id): RedirectResponse
    {
        $statement = $this->statement->findOrFail($id);

        if (!auth()->user()->isAdmin() && !$statement->getSpeciality()->isMy()) {
            return redirect(auth()->user()->home().'/statements/'.$id.'/show')
                ->with('warning', 'Вы не можете изменить статус заявления');
        }
        $statement->accept();

        return redirect(auth()->user()->home().'/statements/'.$id.'/show')
            ->with('success', 'Заявление принято');
    }

    public function refute(int $id): RedirectResponse
    {
        $statement = $this->statement->findOrFail($id);

        if (!auth()->user()->isAdmin() && !$statement->getSpeciality()->isMy()) {
            return redirect(auth()->user()->home().'/statements/'.$id.'/show')
                ->with('warning', 'Вы не можете изменить статус заявления');
        }
        $statement->refute();

        return redirect(auth()->user()->home().'/statements/'.$id.'/show')
            ->with('success', 'Статус заявления изменен');
    }

    public function reject(Request $request): JsonResponse
    {
        $statement = $this->statement->findOrFail($request->id);

        if (!auth()->user()->isAdmin() && !$statement->getSpeciality()->isMy()) {
            $data['error'] = 'Вы не можете изменить статус заявления.';
        }
        $statement->reject($request->message);
        $data = 'Статус заявления изменен';

        return response()->json($data);
    }

    public function going(int $id): RedirectResponse
    {
        $statement = $this->statement->findOrFail($id);

        if (!auth()->user()->isAdmin() && !$statement->getSpeciality()->isMy()) {
            return redirect(auth()->user()->home().'/statements/'.$id.'/show')
                ->with('warning', 'Вы не можете изменить статус заявления');
        }
        $statement->going();

        return redirect(auth()->user()->home().'/statements/'.$id.'/show')
            ->with('success', 'Статус заявления изменен');
    }

    public function refuse(int $id): RedirectResponse
    {
        $statement = $this->statement->findOrFail($id);

        if (!auth()->user()->isAdmin() && !$statement->getSpeciality()->isMy()) {
            return redirect(auth()->user()->home().'/statements/'.$id.'/show')
                ->with('warning', 'Вы не можете изменить статус заявления');
        }
        $statement->refuse();

        return redirect(auth()->user()->home().'/statements/'.$id.'/show')
            ->with('success', 'Статус заявления изменен');
    }

}
