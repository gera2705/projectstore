<?php

namespace App\Http\Controllers\Api\v1;

use App\Candidate;
use App\Http\Controllers\API\ResponseObject;
use App\Http\Controllers\Controller;
use App\Http\Requests\CandidateStoreRequest;
use App\Http\Requests\CandidateStoreRequestApi;
use App\Http\Requests\ProjectStoreRequest;
use App\Http\Requests\ProjectStoreRequestApi;
use App\Http\Requests\ProjectFilterRequest;
use App\Jobs\SendMail;
use App\Mail\CandidateOrderMail;
use App\Project;
use App\ProjectTag;
use App\State;
use App\Type;
use App\User;
use App\Supervisor;
use App\Http\Requests\CreateProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use Illuminate\Support\Collection;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use \Illuminate\Support\Facades\Response as FacadeResponse;

class ProjectController extends Controller
{

    public function create(CreateProjectRequest $request) {
        $token = $request->get('api_token');
        $id = Supervisor::where('api_token', $token)->select('id')->get()[0]['id'];
        
        $project_id = Project::create([
            'supervisor_id' => $id,
            'state_id' => 2, //активный
            'title' => $request['title'],
            'places' => $request['places'],
            'difficulty' => $request['difficulty'],
            'date_start' => $request['date_start'],
            'date_end' => $request['date_end'],
            'goal' => $request['goal'],
            'idea' => $request['idea'],
            'customer' => $request['customer'],
            'type_id' => $request['type'],
            'expected_result' => '',
            'requirements' => $request['requirements'],
        ])->id;

        foreach ($request['tags'] as $tag) {
            if (!is_int($tag)) {
                return response()->json([
                    'status' => false, 
                    'message' => 'Массив тегов содержит не число'], 
                    400); 
            }

            ProjectTag::create([
                'project_id' => $project_id,
                'tag_id' =>  $tag
            ]);
        }


        return response()->json(['success' => 'OK'], 200);
    }

    public function update($id, UpdateProjectRequest $request) {
        $token = $request->get('api_token');
        $id_supervisor = Supervisor::where('api_token', $token)->select('id')->get()[0]['id'];

        $projs = Project::where('supervisor_id', $id_supervisor)->where('id', $id)->get();
        if ($projs->count() == 0) {
            return response()->json(['error' => 'У руководителя нет такого проекта'], 400);
        }

        $updated = [];
        $possibleFiled = ['title', 'places', 'difficulty', 'date_start', 'date_end', 
        'goal', 'idea', 'customer', 'type', 'requirements', 'tags'];

        foreach ($possibleFiled as $v) {
            if (isset($request[$v]))
                $updated[$v] = $request[$v];
        }
        
        Project::where('id', $id)->update($updated);

        return response()->json(['success' => 'OK'], 200);
    }

    public function index() {
        $data = Project::join('states','states.id','=','projects.state_id')->where('states.state','!=','Обработка')
        ->orderBy('updated_at', 'DESC')->select('projects.*')->orderBy('id','desc')->simplePaginate(7);
       
        $data->makeHidden(['state_id', 'supervisor_id', 'type_id']);
        $data = $data->toArray()['data'];
        
       
        return response()->json($data)->setStatusCode(200, 'Paginating 7 projects');
    }

    public function paginate($items, $perPage = 7, $page = null, $options = []) {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    public function filter(Request $request) {
        $data = Project::all();
        
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

        //фильтрация по руководителю
        $supervisors = array_map(function($value) {
            return intval($value);
        }, $request->input('supervisor') ?? []);
        if (count($supervisors) != 0)
            $data = $data->whereIn('supervisor_id', $supervisors);

        //фильтрация по сложности
        $difficulty = array_map(function($value) {
            return intval($value);
        }, $request->input('difficulty') ?? []);
        if (count($difficulty) != 0)
            $data = $data->whereIn('difficulty', $difficulty);

        //фильтрация по тегам
        $tags = array_map(function($value) {
            return intval($value);
        }, $request->input('tags') ?? []);
        if (count($tags) != 0) {
            $idProjectsWithTags = ProjectTag::select('project_id as id')->whereIn('tag_id', $tags)->get()->toArray();
            $idProject = [];
            foreach ($idProjectsWithTags as $key => $value) {
                array_push($idProject, $value['id']);
            } 
            $data = $data->whereIn('id', $idProject);
        }

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
        $dateStart = $request->input('date_start') ?? '';
        $dateEnd = $request->input('date_end') ?? '';

        $dateStart = ltrim($dateStart, '"');
        $dateStart = rtrim($dateStart, '"');
        
        $dateEnd = rtrim($dateStart, '"');
        $dateEnd = ltrim($dateEnd, '"');

        if ($dateStart != '') {
            $data = $data->filter(function ($value) use ($dateStart) {
                return $value->date_start >= $dateStart;
            })->values();
        }
        if ($dateEnd != '') {
            $data = $data->filter(function ($value) use ($dateEnd) {
                return $value->date_end <= $dateEnd;
            })->values();
        }

        $page = intval($request->input('page')) ?? 1;
        $data = $this->paginate($data, 7, $page);
        $data->makeHidden(['state_id', 'supervisor_id', 'type_id']);
       
        $data = $data->toArray()['data'];

       
        $dataArr = [];
        foreach ($data as $key => $value) {
           array_push($dataArr, $value);
        }
        return response()->json(['data' => $dataArr, 'request' => urldecode($_SERVER['REQUEST_URI'])])->setStatusCode(200);
        //return response()->json($dataArr)->setStatusCode(200);
    }

    public function show($project_id) {
        $project = Project::find($project_id);

        if ($project) {
            return response()->json([
                'status' => true,
                'project' => $project
            ])->setStatusCode(200, 'Opening a specified project');
        } else {
            return response()->json(['status'=>false], 401);
        }
    }

    public function store(ProjectStoreRequest $request) {
        $project = Project::create([
            "title" => $request->title,
            "places" => $request->places,
            "state_id" => State::where('state','Обработка')->first()->id,
            "type_id" => Type::where('type',$request->type)->first()->id,
            "goal" => $request->goal,
            "idea" => $request->idea,
            "user_id" => Auth::id(),
            "date_start" => $request->date_start,
            "date_end" => $request->date_end,
            "requirements" => $request->requirements,
            "customer" => $request->customer,
            "expected_result" => $request->expected_result,
            "additional_inf" => $request->additional_inf,
        ]);
        $project->tags()->sync($request->tags);

        return response()->json(["status" => true])->setStatusCode(201, "Project is created");
    }

    public function supervisorProjects() {
        $projects = Project::where('user_id', Auth::id())->paginate(100);

        return response()->json([
                "status" => true,
                "orders" => $projects
            ])->setStatusCode(200, 'supervisor projects list');
    }

    public function storeCandidateOrder(CandidateStoreRequestApi $request,$project_id) {
        $project = Project::where('id',$project_id)->first();
        if (!$project) {
            return response()->json(["status" => false], 404);
        }
        $candidate = Candidate::create([
            'fio' => $request->fio,
            'email' => $request->email,
            'phone' => $request->phone,
            'competencies' => $request->competencies,
            'skill' => $request->skill,
            'course' => $request->course,
            'training_group' => $request->training_group,
            'experience' => $request->experience,
            'project_id' => $project_id,
            'is_mate' => 0
        ]);

        $supervisorEmail = User::where('id',$project->user_id)->first()->email;
        //Mail::to($supervisorEmail)->queue(new CandidateOrderMail($project,$candidate));
        // SendMail::dispatch($supervisorEmail,$project,$candidate);
        return response()->json(['status'=>true])->setStatusCode(201, 'Order has been created');
    }

}
