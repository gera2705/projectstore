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

    public function index() {
        $data = Project::join('states','states.id','=','projects.state_id')->where('states.state','!=','Обработка')
        ->orderBy('updated_at', 'DESC')->select('projects.*')->orderBy('id','desc')->simplePaginate(7);
        $data = $data->toArray()['data'];
        
        return response()->json($data)->setStatusCode(200, 'Paginating 7 projects');
    }

    public function filter(ProjectFilterRequest $request) {
        $projects = Project::join('states','states.id','=','projects.state_id')->where('states.state', '!=' ,'Обработка');
    

        return response()->json($projects)->setStatusCode(200, 'Paginating 7 projects');
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
