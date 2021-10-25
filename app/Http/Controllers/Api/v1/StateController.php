<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\State;

class StateController extends Controller
{
	public function index() {
		$data = State::all()->sortBy('id');
		return response()->json($data->toArray())->setStatusCode(200, "All state");
	}
}