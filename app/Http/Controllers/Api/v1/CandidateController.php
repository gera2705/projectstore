<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Candidate;
use App\Project;
use App\CandidatesSkill;
use App\Participation;
use App\StateParticipation;
use App\ParticipationsSkill;
use App\Http\Requests\CandidateUpdateRequest;
use App\Http\Requests\CreateParticipationsRequest;
use Illuminate\Http\Request;

class CandidateController extends Controller
{
    public function getById($id, Request $request) {
        $data = Candidate::where('id', $id)->get()[0];

        $id_finalState = StateParticipation::where('state', 'Завершил')->select('id')->get()[0]['id'];
        $participation = Participation::select('id_project')->where('id_candidate', $id)->where('id_state', $id_finalState)->pluck('id_project');
        $data['experience'] = $participation;

        return response()->json($data, 200);
    }

	public function index(Request $request) {
        $token = $request->get('api_token');
        $id = Candidate::where('api_token', $token)->select('id')->get()[0]['id'];

        $id_finalState = StateParticipation::where('state', 'Завершил')->select('id')->get()[0]['id'];

		$candidate = Candidate::where('api_token', $token)->get()[0];
        
        $participation = Participation::select('id_project')->where('id_candidate', $id)->where('id_state', $id_finalState)->pluck('id_project');
        $candidate['experience'] = $participation;

        if ($candidate) {
            return response()->json($candidate)->setStatusCode(200, 'Candidate');
        } else {
            return response()->json(['status' => false], 404);
        }
	}

    public function participations(Request $request) {
        $token = $request->get('api_token');
		$id = Candidate::where('api_token', $token)->select('id')->get()[0]['id'];

        $data = Participation::where('id_candidate', $id);

        //заявка ожидает рассмотрения|отклонена|Отозвана
        $data = $data->whereIn('id_state', [1, 4, 5]); 
        $data = $data->simplePaginate(7);
        $data->makeHidden(['id_project', 'id_candidate', 'date']);

        $data = $data->toArray()['data'];
        
        return response()->json($data, 200);
    }

    public function getProjects(Request $request) {
        $token = $request->get('api_token');
		$id = Candidate::where('api_token', $token)->select('id')->get()[0]['id'];

        $data = Participation::where('id_candidate', $id);

        //студент участвует|Завершил|Исключен
        $data = $data->whereIn('id_state', [2, 3, 6]); 
        $data = $data->simplePaginate(7);
        $data->makeHidden(['id_project', 'id_candidate', 'date']);

        $data = $data->toArray()['data'];
        
        return response()->json($data, 200);
    }

    public function deleteParticipations($id_project, Request $request) {
        $id_project = intval($id_project);
        
        $id_cancelState = StateParticipation::where('state', 'Отозвана')->select('id')->get()[0]['id'];

        $token = $request->get('api_token');
		$id = Candidate::where('api_token', $token)->select('id')->get()[0]['id'];

        if (!Participation::where('id_candidate', $id)->where('id_project', $id_project)->get()->count()) {
            return response()->json(['error' => 'Project not found'], 400);
        }
        $data = Participation::where('id_candidate', $id)->where('id_project', $id_project)->update([
            'id_state' => $id_cancelState
        ]);

        return response()->json(['status' => 'OK'], 200);
    }

    public function createParticipation($id_project, CreateParticipationsRequest $request) {
        $id_project = intval($id_project);

        $token = $request->get('api_token');
		$id = Candidate::where('api_token', $token)->select('id')->get()[0]['id'];

        if (Participation::where('id_candidate', $id)->where('id_project', $id_project)->get()->count() != 0) {
            return response()->json(['error' => 'Заявка на этот проект уже есть'], 400);
        }

        if (!Project::where('id', $id_project)->get()->count()) {
            return response()->json(['error' => 'Project not found'], 400);
        }

        $part_id = Participation::create([
            'id_project' => $id_project,
            'id_candidate' => $id,
            'id_state' => StateParticipation::where('state', 'Ожидание рассмотрения')->select('id')->get()->toArray()[0]['id'],
            'motivation' => $request['motivation'],
            'date' => date('Y-m-d')
        ])->id;

        foreach ($request['skills'] as $skill) {
            if (!is_int($skill)) {
                return response()->json([
                    'status' => false, 
                    'message' => 'Массив скиллов содержит не число'], 
                    400); 
            }

            ParticipationsSkill::create([
                'id_skill' => $skill,
                'id_participation' =>  $part_id
            ]);
        }

        return response()->json(['status' => 'OK'], 200);
    }

    public function updateInfo(CandidateUpdateRequest $req) {
        $token = $req->get('api_token');

		$id = Candidate::where('api_token', $token)->select('id')->get()[0]['id'];

        Candidate::where('id', $id)->update([
            'about' => $req['about'], 
            'phone' => $req['phone']
        ]);
        CandidatesSkill::where('id_candidate', $id)->delete();
        foreach ($req['skills'] as $skill) {
            if (!is_int($skill)) {
                return response()->json([
                    'status' => false, 
                    'message' => 'Массив скиллов содержит не число'], 
                    400); 
            }

            CandidatesSkill::create([
                'id_skill' => $skill,
                'id_candidate' => $id 
            ]);
        }

        return response()->json(['status' => true], 200);
    }

    public function getSkills(Request $request) {
        $token = $request->get('api_token');
		$id = Candidate::where('api_token', $token)->select('id')->get()[0]['id'];

        $data = CandidatesSkill::join('skills', 'skills.id', '=', 'candidates_skills.id_skill')
            ->where('id_candidate', $id)->select('skills.id', 'skills.skill')->get();

        return response()->json($data, 200);
    }
}