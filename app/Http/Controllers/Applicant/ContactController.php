<?php

namespace App\Http\Controllers\Applicant;

use App\Http\Controllers\AdminController;
use App\Http\Requests\MessageRequest;
use App\Mail\NewRequestMailer;
use App\Models\Applicant;
use App\Models\College;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\DataTables;

class ContactController extends AdminController
{
    private $college;
    private $applicant;

    public function __construct(
        College $college,
        Applicant $applicant,
    )
    {
        parent::__construct();
        $this->college = $college;
        $this->applicant = $applicant;
    }

    public function contacts(): View|Factory|Application
    {
        return view('applicant.contacts.index');
    }

    public function message(int $id): View|Factory|Application
    {
        $college = $this->college->findOrFail($id);

        return view('applicant.contacts.message', compact('college'));
    }

    public function getContacts(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->college->getAllActive();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return '<a class="text-frame confirm-id" href="/applicant/contacts/' . $row->id . '/message" title="Написать" data-id="' . $row->id . '"><i class="bi bi-envelope"></i></a>';

                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function store(MessageRequest $request): RedirectResponse
    {
        $college = $this->college->findOrFail($request->college_id);
        $applicant = $this->applicant->findOrFail(auth()->user()->applicant_id);
        $request->request->add([
            'user' => $applicant->getFullName(),
            'email' => $applicant->getUser()->email,
        ]);
        Mail::to($college->email)->send(new NewRequestMailer($request->all()));

        return redirect()
            ->route('applicant.index')
            ->with('success', 'Сообщение успешно отправлено');
    }
}
