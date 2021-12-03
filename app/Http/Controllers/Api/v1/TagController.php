<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
	public function index(Request $request) {
		$searchName = $request->get('name') ?? '';

		$data = Tag::all()->sortBy('id');

		$searchName = ltrim($searchName, '"');
		$searchName = rtrim($searchName, '"');

		if ($searchName != '') {
				$data = $data->filter(function ($value) use ($searchName) {
						return (str_starts_with(mb_strtolower($value->tag), mb_strtolower($searchName)) !== false);
				})->values();
		}

		return response()->json($data->toArray())->setStatusCode(200, "All tags");
	}
}