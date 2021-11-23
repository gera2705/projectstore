<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterSupervisorRequest;
use App\Supervisor;
use App\User;
use App\Project;
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

    
    public function getNames(Request $request) {
        $token = $request->get('api_token');
        $id = Supervisor::where('api_token', $token)->select('id')->get()[0]['id'];

        $data = Project::where('supervisor_id', $id)->select('id', 'title')->get();

        $data->makeHidden(['tags', 'type_name', 'vacant_places', 'state_name', 'supervisor_name']);
        return response()->json($data, 200);
    }

    public function getProjects(Request $request) {
        $token = $request->get('api_token');
        $id = Supervisor::where('api_token', $token)->select('id')->get()[0]['id'];

        $data = Project::where('supervisor_id', $id)->get();

         //фильтрация по типу
        $types = array_map(function($value) {
            return intval($value);
        }, $request->input('type') ?? []);
        
        if (count($types) != 0)
            $data = $data->whereIn('type_id', $types);

        //фильтрация по состоянию
        $states = array_map(function($value) {
            return intval($value);
        }, $request->input('state') ?? []);
        if (count($states) != 0)
            $data = $data->whereIn('state_id', $states);

         //фильтрация по названию
        $title = $request->input('title') ?? '';

        $title = ltrim($title, '"');
        $title = rtrim($title, '"');
 
        if ($title != '') {
            $data = $data->filter(function ($value) use ($title) {
                return (strpos(mb_strtolower($value->title), mb_strtolower($title)) !== false);
            })->values();
        }

        
        //фильтрация по датам
        $date = $request->input('sort_date') ?? '';

        $date = ltrim($date, '"');
        $date = rtrim($date, '"');
    

        if ($date != '') {
       
            if ($date == 'ASC') {
                $data = $data->sortBy('date_start');
            }
            else if ($date == 'DESC') {
                $data = $data->sortByDesc('date_start');
            }
        }

        
        $data->makeHidden(['tags', 'supervisor_name', 'goal', 'idea', 'requirements', 'expected_result', 'result',
        'additional_inf', 'result', 'deleted_at', 'updated_at']);
        
        $dataArr = [];
        foreach ($data as $key => $value) {
           array_push($dataArr, $value);
        }
        return response()->json($dataArr, 200);
    }

    public function names() {
        
        $data = Supervisor::select('id', 'fio')->get();
        return response()->json($data, 200);
    }
}
