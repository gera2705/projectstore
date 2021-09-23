<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', 'MainController@index')->name('index'); // главная страница
Route::get('/why-answer', 'MainController@whyAnswer')->name('why-answer'); // "Зачем участвовать в проектах"

// Route::get('/campus_auth', 'Api\v1\CampusAuth@auth');

Route::get('/project/{projectId}', 'ProjectController@show')->name('showProject')->where('projectId','[0-9]+'); // Просмотр одного проекта

Route::group(['middleware'=>'check.openProject'], function() { // навесить посредника, который проверяет явлеятся ил проект "открытым"
    Route::get('/project/{projectId}/participation', 'ProjectController@participate')->name('participation')->where('projectId','[0-9]+'); // страница "Оставить заявку на участие"
    Route::post('/project/{projectId}/candidate', 'CandidateController@store')->name('storeCandidate'); // Создать кандидата (это уже пост-запрос)
});



Route::group(['middleware'=>'auth'], function () { // Проверка, авторизован ли
    Route::group(['middleware' => 'protectPages'], function() { // посредник, защищайющий страницы от "чужих" руководителей
        Route::get('/project/{projectId}/watch/{candidateId}','CandidateController@watch')->name('watch')->where([
            'projectId'=>'[0-9]+',
            'candidateId'=>'[0-9]+',
        ]); // "просмотреть" карточку кандидата
        Route::get('/project/{projectId}/unwatch/{candidateId}','CandidateController@unwatch')->name('unwatch')->where([
            'projectId'=>'[0-9]+',
            'candidateId'=>'[0-9]+',
        ]); // Убрать состояние "просмотрено" из карточки кандидата
        Route::get('/project/{projectId}/assign','ProjectController@assign')->name('assign')->where('projectId','[0-9]+'); // Страница "назначение исполнителей"
        Route::get('/project/{projectId}/assign/{candidateId}','CandidateController@assignMate')->name('assignMate')->where([
            'projectId'=>'[0-9]+',
            'candidateId'=>'[0-9]+',
        ]); // Назначить карточку в качестве исполнителя
        Route::get('/project/{projectId}/detach/{candidateId}','CandidateController@detachMate')->name('detachMate')->where([
            'projectId'=>'[0-9]+',
            'candidateId'=>'[0-9]+',
        ]); // Убрать карточку в качестве исполнителя
        Route::get('/project/{projectId}/changeplaces','ProjectController@changePlaces')->name('changePlaces')->where([
            'projectId'=>'[0-9]+',
        ]); // Изменить количество мест исполнителей в проекте
        Route::post('/project/{projectId}/close','ProjectController@close')->name('closeProject')->where('projectId','[0-9]+'); // Закрыть проект (пост-запрос)
        Route::get('/project/{projectId}/shut', 'ProjectController@shut')->name('shutProject')->where('projectId','[0-9]+'); // Форма закрытия проекта
        Route::get('/project/{projectId}/resume', 'ProjectController@resumeAccepting')->name('resumeAccepting')->where('projectId','[0-9]+'); // Возобновить прием заявок
        Route::get('/project/{projectId}/suspend', 'ProjectController@suspendAccepting')->name('suspendAccepting')->where('projectId','[0-9]+'); // Остановить прием заявок
    });

    Route::group(['middleware' => 'updateProject'], function() { // Посредник обновления проекта --> на экспертизе проект обновлять нельзя (как минимум)
        Route::get('/project/{projectId}/edit', 'ProjectController@edit')->name('editProject')->where('projectId', '[0-9]+'); // Форма редактирования проекта
        Route::put('/project/{projectId}/update', 'ProjectController@update')->name('updateProject')->where('projectId', '[0-9]+'); // Редактирование проекта (пост-запрос)
    });

    Route::post('/project', 'ProjectController@store')->name('storeProject'); // Создание заявки на проект руководителем
    Route::get('/project/create', 'ProjectController@create')->name('createProject'); // Форма создания заявки на проект
    Route::get('personalcab','MainController@personalcab')->name('personalcab'); // Личный кабинет руководителя
});

// Make relationship supervisor and project


// admin dashboard


Route::group(['prefix' => 'admin', 'middleware' => 'check.admin'], function () { // Посредние, является ли админом? также префикс для сокращения надписи вначале

    // admacc
    Route::get('/admacc_expertise', 'AdminController@admacc_expertise')->name('admacc_expertise');
    Route::get('/projects', 'AdminController@admacc_projects')->name('admacc_projects'); // Страница управления проектами
    Route::get('/projects/show/{projectId}','AdminController@admacc_project_show')->name('admacc_project_show')->where('projectId','[0-9]+'); // Показать проект
    Route::get('/projects/delete/{projectId}','ProjectController@destroy')->name('admacc_project_delete')->where('projectId','[0-9]+'); // Удалить проект
    Route::get('/supervisors','AdminController@admacc_supervisors')->name('admacc_supervisors'); // Страница управления руководителями
    Route::post('/supervisors/register','AdminController@admacc_registerSupervisor')->name('admacc_registerSupervisor'); // Зарегистрировать руководителя (пост-запрос)
    Route::get('/tags','AdminController@admacc_tags')->name('admacc_tags'); // Страница справочника тегов
    Route::post('/tags/create','AdminController@admacc_tag_add')->name('admacc_tag_add'); // Создать тег (пост-запрос)
    Route::get('/tags/{tagId}}','AdminController@admacc_tag_delete')->name('admacc_tag_delete'); // Удалить тег (пост-запрос)
    Route::get('/supervisors/delete/{supervisorId}','AdminController@admacc_supervisor_delete')->name('admacc_supervisor_delete'); // Удалить руководителя
    Route::get('/supervisors/edit/{supervisorId}','AdminController@admacc_supervisor_edit')->name('admacc_supervisor_edit'); // Страница редактирования руководителя
    Route::put('/supervisors/update/{supervisorId}','AdminController@admacc_supervisor_update')->name('admacc_supervisor_update'); // Обновить данные руководителя

    // CMS
    Route::get('/expertise', 'AdminController@expertise')->name('expertise'); // Страница "Экспертиза заявок"
    Route::get('/expertise/{projectId}','AdminController@expertiseProject')->name('expertiseProject')->where('projectId','[0-9]+'); // Страница подробного просмотра проекта при одобрении
    Route::get('/expertise/approve/{projectId}','AdminController@approveProject')->name('approveProject')->where('projectId','[0-9]+'); // Одобрить проект
    Route::post('/expertise/reject','AdminController@rejectProject')->name('rejectProject'); // Отклонить проект с причиной (причина в пост-запросе)


    Route::get('/project/{projectId}/shut', 'ProjectController@shut')->name('admshutProject')->where('projectId','[0-9]+'); // Страница закрытия проекта
    Route::post('/project/{projectId}/close','ProjectController@close')->name('admcloseProject')->where('projectId','[0-9]+'); // Закрыть проект (пост-запрос)
    Route::get('/project/{projectId}/delete', 'ProjectController@destroy')->name('admdeleteProject')->where('projectId','[0-9]+'); // Удаление проекта
    Route::get('/toggledesign', 'AdminController@toggleDesign')->name('toggleDesign'); // Функция удаления/создания куки, которая отвечает за показ баннера на главной странице
});

// authentication
Route::post('/login', 'Auth\LoginController@login')->name('login'); // Войти в профиль (руководитель или админ)
Route::get('/logout', 'Auth\LoginController@logout')->name('logout'); // Выйти из профиля (руководитель или админ)


// Сброс пароля
Route::post('/password/email','Auth\ForgotPasswordController@sendResetLinkEmail')->name('resetLinkEmail'); // Отправить письмо по эл. почте
Route::post('/password/reset','Auth\ResetPasswordController@reset')->name('resetPassword'); // Сбросить пароль (это уже на странице при сбрасывании пароля)
Route::get('/password/reset/{token}','Auth\ResetPasswordController@showResetForm')->name('resetForm'); // Сброс пароля, основанный на письме из эл. почты



