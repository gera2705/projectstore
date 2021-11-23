<?php 

namespace App\Http\Controllers\Api\v1;

use App\Candidate;
use App\Http\Controllers\API\ResponseObject;
use App\Http\Controllers\Controller;
use App\Http\Requests\CandidateStoreRequest;
use App\Http\Requests\CandidateStoreRequestApi;
use App\Http\Requests\ProjectStoreRequest;
use App\Http\Requests\ProjectStoreRequestApi;
use App\Http\Requests\ProjectFilterRequest;
use App\Jobs\SendMail;
use App\Mail\CandidateOrderMail;
use App\Project;
use App\ProjectTag;
use App\State;
use App\Type;
use App\User;
use App\Review;
use App\Supervisor;
use App\Http\Requests\CreateProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use Illuminate\Support\Collection;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use \Illuminate\Support\Facades\Response as FacadeResponse;

class ReviewController extends Controller {
  public function get($id, Request $request) {

    $data = Review::where('id_student', $id)->get();

    foreach ($data as $k => $v) {
      $data_project = Project::where('id', $v['id_project'])->get()[0];
      $data[$k]['supervisor'] = Supervisor::where('id', $data_project['supervisor_id'])->get()[0]['fio'];
      $data[$k]['title_project'] = $data_project['title'];
    }
   
    $data->makeHidden(['id_project', 'id_student']);
    return response()->json($data, 200);
  }
}