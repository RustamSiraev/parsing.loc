<?php

namespace App\Http\Controllers\Applicant;

use App\Http\Controllers\AdminController;
use App\Http\Requests\SignupRequest;
use App\Models\Applicant;
use App\Models\House;
use App\Models\Street;
use App\Models\User;
use DB;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class ApplicantController extends AdminController
{
    private $user;
    private $applicant;

    public function __construct(
        User $user,
        Applicant $applicant,
    )
    {
        parent::__construct();
        $this->user = $user;
        $this->applicant = $applicant;
    }

    public function index(): View|Factory|Application
    {
        return view('applicant.index');
    }

    public function edit(): View|Factory|Application
    {
        $applicant = $this->applicant->findOrFail(auth()->user()->applicant_id);

        return view('applicant.edit', compact('applicant'));
    }

    public function update(SignupRequest $request, Applicant $applicant): RedirectResponse
    {
        DB::beginTransaction();

        try {
            if (!$request->matches) {
                $fact_street = Street::firstOrCreate(
                    ['guid' =>  $request->fact_street_id],
                    ['title' => $request->fact_city_street]
                );
                $fact_house = House::firstOrNew(
                    ['guid' =>  $request->fact_street_id.'-'.$request->fact_house_num],
                );
                $fact_house->street_id = $fact_street->id;
                $fact_house->house_num = $request->fact_house_num;
                $fact_house->guid = $request->fact_street_id.'-'.$request->fact_house_num;
                $fact_house->save();

                $request->request->add(['fact_house_id' => $fact_house->id]);
            }
            $street = Street::firstOrCreate(
                ['guid' => $request->street_id],
                ['title' => $request->city_street]
            );

            $house = House::firstOrNew(
                ['guid' => $request->street_id . '-' . $request->house_num],
            );
            $house->street_id = $street->id;
            $house->house_num = $request->house_num;
            $house->guid = $request->street_id . '-' . $request->house_num;
            $house->save();

            $request['matches'] = empty($request['matches']) ? 0 : 1;
            $request->request->add(['house_id' => $house->id]);

            $applicant->update($request->all());

            $fullName = $request->l_name . ' ' . $request->f_name;
            if ($request->m_name != '') $fullName .= ' ' . $request->m_name;

            $this->user->where('applicant_id', $applicant->id)->first()->update([
                'name' => $fullName,
                'phone' => $request->phone,
                'email' => $request->email,
            ]);

            DB::commit();

            return redirect()
                ->route('applicant.edit', compact('applicant'))
                ->with('success', 'Данные успешно изменены');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->route('applicant.edit', compact('applicant'))
                ->with('warning', 'При обработке запроса произошла ошибка. Пожалуйста, попробуйте ещё раз позже.');
        }
    }

    public function downloadFile($file_name): Response
    {
        $file = Storage::disk('public')->get($file_name);

        return (new Response($file, 200))
            ->header('Content-Type', 'image/jpeg');
    }
}
