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

Route::get('/projects', 'Api\v1\ProjectController@index'); 
Route::get('/projects/filter', 'Api\v1\ProjectController@filter');
Route::get('/tags', 'Api\v1\TagController@index');
Route::get('/types', 'Api\v1\TypeController@index');
Route::get('/states', 'Api\v1\StateController@index');

/*
 * Candidates Routes
 */
Route::group(['middleware'=>['apiAuth']], function() {
    Route::get('/candidate', 'Api\v1\CandidateController@index');
    Route::put('/candidate', 'Api\v1\CandidateController@updateInfo');

    Route::get('/participations', 'Api\v1\CandidateController@participations');
    Route::delete('/participations/{id}', 'Api\v1\CandidateController@deleteParticipations')->where('id','[0-9]+');
    Route::post('/participations/{id}', 'Api\v1\CandidateController@createParticipation')->where('id','[0-9]+');    

    Route::get('/candidate/skills', 'Api\v1\CandidateController@getSkills');
});

Route::group(['middleware'=>['apiAuth']], function() {
    //проекты
    Route::get('/supervisor/projects', 'Api\v1\SupervisorController@getProjects');
    Route::post('/supervisor/projects', 'Api\v1\ProjectController@create');
    Route::put('/supervisor/projects/{id}', 'Api\v1\ProjectController@update')->where('id','[0-9]+');
    Route::get('/supervisor/projects/names', 'Api\v1\SupervisorController@getNames');

    //личный кабинет
    Route::get('/supervisor', 'Api\v1\SupervisorController@get');
    Route::put('/supervisor', 'Api\v1\SupervisorController@updateAbout');
});




Route::get('/skills', 'Api\v1\SkillsController@index');


/*
 * Supervisors Routes
 */
Route::get('/supervisors/names', 'Api\v1\SupervisorController@names');


// Route::get('/project/{projectId}','Api\v1\ProjectController@show')->where('projectId','[0-9]+'); // show one project by its id
//Route::post('/project/{projectId}/candidate','Api\v1\ProjectController@storeCandidateOrder')->where('projectId','[0-9]+'); // store candidate order



