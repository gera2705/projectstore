<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Skill;
use Illuminate\Http\Request;

class SkillsController extends Controller
{
	public function index(Request $request) {
		$data = Skill::all()->sortBy('id');

		$searchName = $request->get('name') ?? '';

		$searchName = ltrim($searchName, '"');
		$searchName = rtrim($searchName, '"');

		if ($searchName != '') {
				$data = $data->filter(function ($value) use ($searchName) {
						return (str_starts_with(mb_strtolower($value->skill), mb_strtolower($searchName)) !== false);
				})->values();
		}

		return response()->json($data->toArray())->setStatusCode(200, "All skills");
	}
}