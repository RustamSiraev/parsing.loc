<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\SignupRequest;
use App\Models\Applicant;
use App\Models\House;
use App\Models\Parents;
use App\Models\Street;
use App\Models\User;
use Auth;
use DB;
use Hash;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;

class SignupController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('password');
    }

    public function index(): Factory|View|Application
    {
        return view('auth.register');
    }

    public function register(): Factory|View|Application
    {
        return view('auth.register');
    }

    public function password(): Factory|View|Application
    {
        $user = auth()->user();
        $back = $user->home();

        return view('auth.passwords.change-password', compact('user', 'back'));
    }

    public function create(SignupRequest $request): Factory|View|RedirectResponse|Application
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
                ['guid' =>  $request->street_id],
                ['title' => $request->city_street]
            );

            $house = House::firstOrNew(
                ['guid' =>  $request->street_id.'-'.$request->house_num],
            );
            $house->street_id = $street->id;
            $house->house_num = $request->house_num;
            $house->guid = $request->street_id.'-'.$request->house_num;
            $house->save();

            $request['matches'] = empty($request['matches']) ? 0 : 1;
            $request->request->add(['house_id' => $house->id]);

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
                'password' => Hash::make($request->password),
            ]);
            $user->refreshRoles($user->role->slug);

            DB::commit();

            Auth::login($user);

            return redirect()
                ->route('login')
                ->with('success', 'Вы успешно зарегистрировались');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->route('register')
                ->with('warning', 'При обработке запроса произошла ошибка. Пожалуйста, попробуйте ещё раз позже.');
        }
    }
}
