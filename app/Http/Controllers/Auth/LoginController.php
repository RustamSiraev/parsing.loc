<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Auth;
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
    protected string $redirectTo = RouteServiceProvider::HOME;

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
