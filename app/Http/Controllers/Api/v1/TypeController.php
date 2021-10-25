<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Type;

class TypeController extends Controller
{
	public function index() {
		$data = Type::all()->sortBy('id');
		return response()->json($data->toArray())->setStatusCode(200, "All types");
	}
}