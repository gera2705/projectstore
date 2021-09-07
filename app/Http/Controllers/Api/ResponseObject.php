<?php
namespace App\Http\Controllers\API;

class ResponseObject {
    const status_ok = "OK";
    const status_fail = "FAIL";
    const code_ok = 200;
    const code_failed = 400;
    const code_unauthorized = 403;
    const code_not_found = 404;
    const code_error = 500;

    public $status;

    public $code;

    public $messages = array();

    public $result = array();
}

//$response = new ResponseObject;
//
//
//$validator = Validator::make($request->json()->all(), [
//    'fio'=>'required|max:255',
//    'email'=>'required|max:255',
//    'phone'=>'required|max:255',
//    'competencies'=>'required|max:255',
//    'skill'=>'required',
//    'course'=>'required',
//    'training_group'=>'required',
//    'experience'=>'required',
//    'personconfirm'=>'required',
//]);
//
//if ($validator->fails()) {
//    $response->status = $response::status_fail;
//    $response->code = $response::code_failed;
//    foreach ($validator->errors()->getMessages() as $item) {
//        array_push($response->messages,$item);
//    }
//} else {
//    $project = Project::where('id',$project_id)->first();
//    if (!$project) {
//        return response()->json([
//            "status" => false,
//        ], 401);
//    }
//    $candidate = Candidate::create([
//        'fio'=>$request->fio,
//        'email'=>$request->email,
//        'phone'=>$request->phone,
//        'competencies'=>$request->competencies,
//        'skill'=>$request->skill,
//        'course'=>$request->course,
//        'training_group'=>$request->training_group,
//        'experience'=>$request->experience,
//        'project_id'=>$project_id,
//        'is_mate'=>0,
//    ]);
//    $response->status = $response::status_ok;
//    $response->code = $response::code_ok;
//    $response->result = $candidate;
//}
//
//return FacadeResponse::json($response);


