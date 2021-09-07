<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterSupervisorRequest;
use App\Supervisor;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterSupervisorRequestApi;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\LoginSupervisorRequestApi;
use Illuminate\Support\Str;

class SupervisorController extends Controller
{

    /**
     * Регистрация Руководителей через API
     * @param RegisterSupervisorRequestApi
     * @return \Illuminate\Http\JsonResponse|object
     */

    public function register(RegisterSupervisorRequest $request) {

        /*
         * Добавление руководителя в БД
         */

        User::create (
            [
                'username' => $request->login,
                'password' => Hash::make($request->password),
                'fio'=> $request->fio,
                'email'=> $request->email,
                'position'=> $request->position
            ]
        );

        /*
         * Возвращаем ответ
         */

        return response()
            ->json(["status"=>true])
            ->setStatusCode(201,"Supervisor has been registered");
    }

    /*
     * Авторизация пользователя API
     */

    public function login(Request $request) {

        /*
         * Ищем пользователя по логину
         */

        $supervisor = User::where('username',$request->login)->first();

        /*
         * Если пользователь найден и пароль совпадает, значит возвращаем токен и данные о пользователе
         */

        if ($supervisor && Hash::check($request->password,$supervisor->password)) {

            /*
             * Генерируем токен и обновляем о пользователя
             */

            $supervisor->api_token = Str::random(100);
            $supervisor->save();

            /*
             * Успешный ответ
             */

            return response()->json([
                "status" => true,
                "supervisor" => $supervisor
            ])->setStatusCode(200, 'Supervisor Authenticated');
        }
        else {

            /*
             * Неуспешный ответ
             */

            return response()->json([
                "status"=>false,
                ],401);
            }

        }
}
