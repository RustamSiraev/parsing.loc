<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Auth;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    function authenticated(Request $request, $user)
    {
        if (!$user->status) {
            Auth::logout();
            throw ValidationException::withMessages(['status' => __('The account is inactive')]);
        }

        $counter = $user->sign_in_count + 1;
        $user->update([
            'last_sign_in_at' => Carbon::now()->toDateTimeString(),
            'sign_in_count' => $counter,
            'last_sign_in_ip' => $request->getClientIp()
        ]);
    }

    public function redirectTo()
    {
        return auth()->user()->home();
    }

    protected function credentials(Request $request)
    {
        return [
            'email' => request()->email,
            'password' => request()->password
        ];
    }
}
