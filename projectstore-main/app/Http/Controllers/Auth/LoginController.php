<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginSupervisorRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    protected function attemptLogin(Request $request)
    {
        return $this->guard()->attempt(
            $this->credentials($request)
        );
    }

//    public function login(LoginSupervisorRequest $request) {
//        $data = $request->except(['_token', 'g-recaptcha-response']);
//        if(Auth::attempt($data)) {
//            return redirect(route('index'));
//        } else {
//            return redirect(route('index'))->with([
//                'failed' => 'Wrong username or password'
//            ]);
//        }
//    }

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

    /**
     * В качестве логниа используется логин (по-умолчанию использовался email)
     * @return string
     */

    public function username()
    {
        return 'username';
    }

    /**
     * Конкретизация ошибки, которая будет в переменной error после отправки назад на сервер
     * Используется для отправки ответа, если авторизация прошла неудачно (здесь редирект назад и
     * вывод ошибки в переменной error, которая выводится уже в шаблоне)
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */

    protected function sendFailedLoginResponse(Request $request)
    {
        return redirect()->back()->with('error','Неправильный логин/пароль');
    }

}
