<?php


use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});


/*
 * User Routes
 */

Route::post('/register','Api\v1\SupervisorController@register'); // Register Supervisor
Route::post('/login','Api\v1\SupervisorController@login'); // Login Supervisor

/*
 * Projects Routes
 */

Route::group(['middleware'=>['auth:api']], function () {
    Route::post('/project','Api\v1\ProjectController@store'); // Add project
    Route::get('/supervisorprojects','Api\v1\ProjectController@supervisorProjects'); // Get supervisor's project
});

/*
 * News Routes
 */

Route::get('/projects','Api\v1\ProjectController@index'); // get last 100 projects
Route::get('/projects/process','Api\v1\ProjectController@process'); // get processed projects
Route::get('/projects/open','Api\v1\ProjectController@open'); // get open projects
Route::get('/projects/active','Api\v1\ProjectController@active'); // get active projects
Route::get('/projects/close','Api\v1\ProjectController@close'); // get closed projects


Route::get('/project/{projectId}','Api\v1\ProjectController@show')->where('projectId','[0-9]+'); // show one project by its id
Route::post('/project/{projectId}/candidate','Api\v1\ProjectController@storeCandidateOrder')->where('projectId','[0-9]+'); // store candidate order

Route::get('/skills', 'Api\v1\SkillsController@index');

//public function index() {
//    return response()->json(Post::all())->setStatusCode(200,"Posts list");
//}
