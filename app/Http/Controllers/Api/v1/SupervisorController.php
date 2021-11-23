<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterSupervisorRequest;
use App\Supervisor;
use App\User;
use App\Participation;
use App\Project;
use App\Candidate;
use App\Review;
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

    public function get(Request $request) {
        $token = $request->get('api_token');
        $data = Supervisor::where('api_token', $token)->get()[0];

        return response()->json($data, 200);
    }

    
    public function getNames(Request $request) {
        $token = $request->get('api_token');
        $id = Supervisor::where('api_token', $token)->select('id')->get()[0]['id'];

        $data = Project::where('supervisor_id', $id)->select('id', 'title')->get();

        $data->makeHidden(['tags', 'type_name', 'vacant_places', 'state_name', 'supervisor_name']);
        return response()->json($data, 200);
    }

    public function getParicipateProject($idProject, Request $request) {
        $token = $request->get('api_token');
        $id = Supervisor::where('api_token', $token)->select('id')->get()[0]['id'];


        $projects = Project::where('supervisor_id', $id)->where('id', $idProject)->get();
        if ($projects->count() == 0) {
            return response()->json(['error' => 'Этот проект не принадлежит руководителю'], 200);
        }


        $data = Participation::where('id_project', $idProject)->where('id_state', 2)->get();
    
        foreach ($data as $key => $value) {
            $fio = Candidate::where('id', $value['id_candidate'])->select('fio')->get()[0]['fio'];
            $data[$key]['fio'] = $fio;
        }

        $data = $data->sortByDesc('date');
        
        $data->makeHidden(['project', 'id_state', 'id_candidate', 'id_project', 'state', 'motivation', 'date']);
        return response()->json($data, 200);
    }

    public function getParticipations(Request $request) {
        $token = $request->get('api_token');
        $id = Supervisor::where('api_token', $token)->select('id')->get()[0]['id'];

        $projects = Project::where('supervisor_id', $id)->select('id', 'title')->get();
        $id_projects = [];
        foreach ($projects as $project) {
            array_push($id_projects, $project['id']);
        }

        $data = Participation::whereIn('id_project', $id_projects)->where('id_state', 1)->get();
    
        foreach ($data as $key => $value) {
            $fio = Candidate::where('id', $value['id_candidate'])->select('fio')->get()[0]['fio'];

            $data[$key]['fio'] = $fio;
            $data[$key]['project_title'] = $value['project']['title'];
        }

        $data = $data->sortByDesc('date');
        
        $data->makeHidden(['project', 'id_state', 'id_candidate', 'id_project', 'state', 'motivation', 'date']);
        return response()->json($data, 200);
    }

    public function removeParticipate($id, Request $request) {
        Participation::where('id', $id)->update(['id_state' => 6]); //исключен

        $data = Participation::where('id', $id)->get()[0];


        if (isset($request['review'])) {
            Review::create([
                'text' => $request['review'],
                'id_student' => $data['id_candidate'],
                'id_project' => $data['id_project'],
                'date' => date('Y-m-d')     
            ]);
        }

        return response()->json(['success' => 'OK'], 200);
    }

    public function getPaticipate($id_part, Request $request) {
        $token = $request->get('api_token');
        $id = Supervisor::where('api_token', $token)->select('id')->get()[0]['id'];

        $projects = Project::where('supervisor_id', $id)->select('id', 'title')->get();
        $id_projects = [];
        foreach ($projects as $project) {
            array_push($id_projects, $project['id']);
        }

        $id_project = Participation::where('id', $id_part)->get()[0]['id_project'];
        if (!in_array($id_project, $id_projects)) {
            return response()->json(['error' => 'Заявка не относится к проекту преподавателя'], 403);
        }

        $data = Participation::where('id', $id_part)->get()[0];
        $data_student = Candidate::where('id', $data['id_candidate'])->get()[0];
        $data_project = Project::where('id', $data['id_project'])->get()[0];
        
        $data['project_title'] = $data['project']['title'];
        $data->makeHidden(['id_project', 'id_state', 'state', 'project']);

        $data['group'] = $data_student['training_group'];
        $data['phone'] = $data_student['phone'];
        $data['email'] = $data_student['email'];
        $data['tags'] = $data_project['tags'];

        return response()->json($data, 200);
    }

    public function updateAbout(Request $request) {
        $token = $request->get('api_token');
        $id = Supervisor::where('api_token', $token)->select('id')->get()[0]['id'];

        if (isset($request['about'])) {
            Supervisor::where('id', $id)->update(['about' => $request['about']]);
        }

        return response()->json(['success' => 'OK'], 200);
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
