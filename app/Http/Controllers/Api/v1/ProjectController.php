<?php

namespace App\Http\Controllers\Api\v1;

use App\Candidate;
use App\Http\Controllers\API\ResponseObject;
use App\Http\Controllers\Controller;
use App\Http\Requests\CandidateStoreRequest;
use App\Http\Requests\CandidateStoreRequestApi;
use App\Http\Requests\ProjectStoreRequest;
use App\Http\Requests\ProjectStoreRequestApi;
use App\Jobs\SendMail;
use App\Mail\CandidateOrderMail;
use App\Project;
use App\State;
use App\Type;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use \Illuminate\Support\Facades\Response as FacadeResponse;

class ProjectController extends Controller
{

    /**
     * Получение обработка-проектов
     * @return \Illuminate\Http\JsonResponse
     */

    public function process() {
        return response()->json(Project::all()->sortByDesc('id')->where('state_id',State::where('state','Обработка')->first()->id))->setStatusCode(200,"Processing projects");
    }

    /**
     * Получение закрытых проектов
     * @return \Illuminate\Http\JsonResponse
     */

    public function close() {
        return response()->json(Project::all()->sortByDesc('id')->where('state_id',State::where('state','Закрытый')->first()->id))->setStatusCode(200,"Closed projects");
    }

    /**
     * Получение активных проектов
     * @return \Illuminate\Http\JsonResponse
     */

    public function active() {
        return response()->json(Project::all()->sortByDesc('id')->where('state_id',State::where('state','Активный')->first()->id))->setStatusCode(200,"Active projects");
    }

    /**
     * Получение открытых проектов
     * @return \Illuminate\Http\JsonResponse
     */

    public function open() {
        return response()->json(Project::all()->sortByDesc('id')->where('state_id',State::where('state','Открытый')->first()->id))->setStatusCode(200,"Open projects");
    }

    /**
     * Получение всех проектов
     * @return \Illuminate\Http\JsonResponse
     */

    public function index() {
//        return response()->json(Project::paginate(3))->setStatusCode(200,"Posts list");
        return response()->json([
            "status"=>true,
//            "projects"=>Project::where('state','<>','Обработка')->orderByRaw("CASE state
//                                WHEN 'Открытый' THEN 1
//                                WHEN 'Активный' THEN 2
//                                WHEN 'Закрытый' THEN 3
//                                ELSE 4
//                                END")->orderBy('id','desc')->paginate(7)
            "projects"=>Project::join('states','states.id','=','projects.state_id')->where('states.state','!=','Обработка')
                ->orderBy('states.priority', 'asc')->select('projects.*')->orderBy('id','desc')->paginate(7)
        ])->setStatusCode(200,'Paginating 7 projects');
    }

    /**
     * Просмотр одного проекта по id
     * @return \Illuminate\Http\JsonResponse
     */

    public function show($project_id) {
        $project = Project::find($project_id);
        if ($project) {
            return response()->json([
                "status"=>true,
                "project"=>$project
            ])->setStatusCode(200,'Opening a specified project');
        }
        else {
            return response()->json([
                "status"=>false,
            ],401);
        }
    }

    /** Добавление новой заявки
     * @param ProjectStoreRequestApi $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function store(ProjectStoreRequest $request) {

        /*
         * Создаем заявку
         */

        $project = Project::create(
            [
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
            ]
        );
        $project->tags()->sync($request->tags);

        /*
         * Выводим ответ
         */

        return response()->json([
            "status" => true
        ])->setStatusCode(201,"Project is created");
    }

    /**
     * Получение всех своих заявок (супервайзора)
     * @return \Illuminate\Http\JsonResponse
     */

    public function supervisorProjects() {

        $projects = Project::where('user_id', Auth::id())->paginate(100);

        return response()
            ->json([
                "status" => true,
                "orders" => $projects
            ])
            ->setStatusCode(200,'supervisor projects list');
    }

    /**
     * Создание заявки от кандидата
     * @param CandidateStoreRequestApi $request
     * @param $project_id
     * @return \Illuminate\Http\JsonResponse
     */

    public function storeCandidateOrder(CandidateStoreRequestApi $request,$project_id) {
        $project = Project::where('id',$project_id)->first();
        if (!$project) {
            return response()->json([
                "status" => false,
            ], 404);
        }
        $candidate = Candidate::create([
            'fio'=>$request->fio,
            'email'=>$request->email,
            'phone'=>$request->phone,
            'competencies'=>$request->competencies,
            'skill'=>$request->skill,
            'course'=>$request->course,
            'training_group'=>$request->training_group,
            'experience'=>$request->experience,
            'project_id'=>$project_id,
            'is_mate'=>0,
        ]);

        $supervisorEmail = User::where('id',$project->user_id)->first()->email;
        //Mail::to($supervisorEmail)->queue(new CandidateOrderMail($project,$candidate));
        // SendMail::dispatch($supervisorEmail,$project,$candidate);
        return response()->json([
            'status'=>true
        ])->setStatusCode(201,'Order has been created');
    }

}
