<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\SignupRequest;
use App\Models\User;
use Auth;
use DB;
use Hash;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Throwable;

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

    /**
     * @throws Throwable
     */
    public function create(SignupRequest $request): Factory|View|RedirectResponse|Application
    {
        DB::beginTransaction();

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'role_id' => 2,
                'remember_token' => Str::random(10),
                'password' => Hash::make($request->password),
            ]);
            $user->refreshRoles($user->role->slug);

            DB::commit();

            Auth::login($user);

            return redirect()
                ->route('login')
                ->with('success', __('You have registered successfully'));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->route('register')
                ->with('warning', __('Whoops! Something went wrong.'));
        }
    }
}
