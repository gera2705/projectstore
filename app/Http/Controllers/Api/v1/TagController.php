<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Tag;

class TagController extends Controller
{
	public function index() {
		$data = Tag::all()->sortBy('id');
		return response()->json($data->toArray())->setStatusCode(200, "All tags");
	}
}