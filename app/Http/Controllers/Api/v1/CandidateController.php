<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Candidate;
use App\CandidatesSkill;
use App\Participation;
use App\StateParticipation;
use App\Http\Requests\CandidateUpdateRequest;
use Illuminate\Http\Request;

class CandidateController extends Controller
{
	public function index($id) {
		$candidate = Candidate::find($id);

        if ($candidate) {
            return response()->json($candidate)->setStatusCode(200, 'Candidate');
        } else {
            return response()->json(['status' => false], 404);
        }
	}

    public function participations($id) {
        $data = Participation::where('id_candidate', $id)->get();

        return response()->json($data, 200);
    }

    public function deleteParticipations($id, Request $request) {
        $id_project = $request->query('id_project');
        if (!isset($id_project) || !is_numeric($id_project)) {
            return response()->json(['status' => false, 'msg' => 'Неверный формат id проекта'], 400);
        }
        
        $id_project = intval($request->query('id_project'));
        $id_cancelState = StateParticipation::where('state', 'Отозвана')->select('id')->get()[0]['id'];

        $data = Participation::where('id_candidate', $id)->where('id_project', $id_project)->update([
            'id_state' => $id_cancelState
        ]);

        return response()->json(['status' => 'OK'], 200);
    }

    public function updateInfo($id, CandidateUpdateRequest $req) {
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
        //return response()->json($req);
        return response()->json(['status' => true], 200);
    }
}