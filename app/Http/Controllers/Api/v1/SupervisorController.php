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
        User::create (
            [
                'username' => $request->login,
                'password' => Hash::make($request->password),
                'fio'=> $request->fio,
                'email'=> $request->email,
                'position'=> $request->position
            ]
        );
        return response()
            ->json(["status"=>true])
            ->setStatusCode(201,"Supervisor has been registered");
    }

    public function login(Request $request) {
        $supervisor = User::where('username',$request->login)->first();
        if ($supervisor && Hash::check($request->password,$supervisor->password)) {
            $supervisor->api_token = Str::random(100);
            $supervisor->save();
            return response()->json([
                "status" => true,
                "supervisor" => $supervisor
            ])->setStatusCode(200, 'Supervisor Authenticated');
        }
        else {
            return response()->json([
                "status"=>false,
                ],401);
        }
    }

    public function names() {
        $data = Supervisor::select('id', 'fio')->get();
        return response()->json($data, 200);
    }
}
