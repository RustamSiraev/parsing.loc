<?php

namespace App\Http\Controllers\Minobr;

use App\Http\Controllers\AdminController;
use App\Http\Requests\RanoRequest;
use App\Models\Guno;
use App\Models\Rano;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class RanoController extends AdminController
{
    private $guno;

    public function __construct(
        Guno $guno,
    )
    {
        parent::__construct();
        $this->guno = $guno;
    }
    public function create(): Factory|View|Application
    {
        $gunos = $this->guno->getAll();

        return view('minobr.rano.create', compact('gunos'));
    }

    public function edit(Rano $rano): Factory|View|Application
    {
        $gunos = $this->guno->getAll();

        return view('minobr.rano.edit', compact('rano', 'gunos'));
    }

    public function store(RanoRequest $request): RedirectResponse
    {
        Rano::create($request->all());

        return redirect()
            ->route('minobr.ranos')
            ->with('success', 'Новый РОО успешно создан');
    }

    public function update(RanoRequest $request, Rano $rano): RedirectResponse
    {
        $rano->update($request->all());

        return redirect()
            ->route('minobr.ranos')
            ->with('success', 'РОО успешно изменён');
    }

    public function deleteRano(Request $request): JsonResponse|RedirectResponse
    {
        $rano = Rano::findOrFail($request->id);

        if ($rano->getSchools() || $rano->getUsers()) {
            return response()->json(['error' => 'Нельзя удалить РОО с прикрепленными пользователями или школами.']);
        } else {
            $rano->delete();
            return response()->json(['success' => 'Successfully.']);
        }
    }
}
