<?php

namespace App\Http\Controllers;

use App\Http\Requests\MessageRequest;
use App\Mail\NewRequestMailer;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;

class ContactController extends AdminController
{
    public function message(): View|Factory|Application
    {
        return view('applicant.contacts.message');
    }

    public function store(MessageRequest $request): RedirectResponse
    {
        $admin = User::where('role_id', 1)->first();

        $request->request->add([
            'user' => auth()->user()->name,
            'email' => auth()->user()->email,
        ]);
        Mail::to($admin->email)->send(new NewRequestMailer($request->all()));

        return redirect(auth()->user()->home())
            ->with('success', 'Сообщение успешно отправлено');
    }
}
