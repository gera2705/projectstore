<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Skill;

class SkillsController extends Controller
{
	public function index() {
		$data = Skill::all()->sortBy('id');
		return response()->json($data->toArray())->setStatusCode(200, "All skills");
	}
}