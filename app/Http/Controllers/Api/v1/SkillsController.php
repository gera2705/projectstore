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
use App\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use \Illuminate\Support\Facades\Response as FacadeResponse;

class SkillsController extends Controller
{
	public function index() {
		$data = Skill::all()->sortBy('id');
		return response()->json($data->toArray())->setStatusCode(200, "All skills");
	}
}