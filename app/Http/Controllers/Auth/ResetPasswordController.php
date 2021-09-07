<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Задать сбрасывающую форму (в данном случае задается шаблон и доп. параметры к нему)
     * @param Request $request
     * @param null $token
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function showResetForm(Request $request, $token = null)
    {
        return view('emails.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    /**
     * Метод сброса пароля, закомментирована функция "запомни меня" и авторизация после сброса, пользователю
     * нужно самостоятельно ввести учетные данные
     * @param $user
     * @param $password
     */

    protected function resetPassword($user, $password)
    {
        $this->setUserPassword($user, $password);

        //$user->setRememberToken(Str::random(60));

        $user->save();

        event(new PasswordReset($user));

        //$this->guard()->login($user);
    }

    /**
     * Правила валидации на форме сброса пароля
     * @return string[]
     */

    protected function rules()
    {
        return [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:3',
        ];
    }

    /**
     * Задать успешный ответ
     * в данном случае просто редирект на главную с успешным оповещением, что пароль сброшен успешно.
     * @param Request $request
     * @param $response
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */

    protected function sendResetResponse(Request $request, $response)
    {
        return redirect($this->redirectPath())
            ->with('success', trans($response));
    }
}
