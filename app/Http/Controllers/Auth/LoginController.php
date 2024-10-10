<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\EmployeeShift;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function login(Request $request)
    {
        $this->validateLogin($request);

        if (
            method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)
        ) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            if ($request->hasSession()) {
                $request->session()->put('auth.password_confirmed_at', time());
            }
            if (auth()->user() && auth()->id()) {
                $prevShift = EmployeeShift::where('user_id', auth()->id())->where('status', 1)->first();
                if (!$prevShift) {
                    EmployeeShift::create([
                        'user_id' => auth()->id(),
                        'clock_in' => now(),
                    ]);
                }
            }

            return $this->sendLoginResponse($request);
        }

        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    public function logout(Request $request)
    {
        if (auth()->user() && auth()->id()) {
            $prevShift = EmployeeShift::where('user_id', auth()->id())->where('status', 1)->first();
            if ($prevShift) {
                $prevShift->update([
                    'clock_out' => now(),
                    'status' => 2
                ]);
            }
        }

        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }

    protected function credentials(Request $request)
    {
        $login = $request->input($this->username());

        $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

        return [
            $fieldType => $login,
            'password' => $request->input('password')
        ];
    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
