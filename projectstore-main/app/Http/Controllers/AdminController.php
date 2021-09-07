<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterSupervisorRequest;
use App\Http\Requests\RejectRequest;
use App\Jobs\SendApprovalMail;
use App\Project;
use App\State;
use App\Tag;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{

    /*
     * Страница "Экспертиза заявок"
     */

    public function expertise() {
        $projects = Project::where('state_id',State::where('state','Обработка')->first()->id)
            ->where('is_scanned',0)->orderBy('updated_at','desc')->paginate(15);
        return view('admin/expertise',compact('projects'));
    }

    /*
     * Одобрить проект
     */

    public function approveProject($id) {
        $project = Project::findOrFail($id);
        $projects = Project::where('state_id',State::where('state','Обработка')->first()->id)->where('is_scanned',0)->get();
        if ($project->state_name != "Обработка")
            return redirect()->route('expertise',compact('projects'))->with('error','Проект "'. $project->title .'" не находится на стадии обработки');
        if (!(is_null($project->error_message)))
            $project->error_message = null;
        $project->state_id = State::where('state','Открытый')->first()->id;
        $project->is_scanned = 1;
        $project->save();
        $supervisorEmail = User::where('id',$project->user_id)->first()->email;
        SendApprovalMail::dispatch($supervisorEmail,$project);
        return redirect()->route('expertise',compact('projects'))->with('success','Проект "'.$project->title.'" успешно одобрен');
    }

    /*
     * Отклонить проект
     */

    public function rejectProject(RejectRequest $request) {
        $project = Project::findOrFail($request->project_id);
        $projects = Project::where('state_id',State::where('state','Обработка')->first()->id)->where('is_scanned',0)->get();
        if ($project->state_name != "Обработка")
            return redirect()->route('expertise',compact('projects'))->with('error','Проект "'. $project->title .'" не находится на стадии обработки');
        $project->error_message = $request->error_message;
        $project->is_scanned = 1;
        $project->save();
        $supervisorEmail = User::where('id',$project->user_id)->first()->email;
        SendApprovalMail::dispatch($supervisorEmail,$project);
        return redirect()->route('expertise',compact('projects'))->with('success','Проект "'.$project->title.'" успешно отклонен');;
    }

    /*
     * Подробный просмотр одного проекта при экспертизе
     */

    public function expertiseProject($id) {
        $project = Project::findOrFail($id);
        return view('admin.detailed',compact('project'));
    }

    /*
     * "Показать элементы дизайна"
     */

    public function toggleDesign() {
        if (Cookie::has('offDesign'))
            Cookie::queue(Cookie::forget('offDesign'));
        else
            Cookie::queue(Cookie::forever('offDesign','1'));
        return redirect()->back();
    }



    /*
     * Страница "проекты" ЛК
     */

    public function admacc_projects() {
//        $projects = Project::orderByRaw("CASE state
//                                WHEN 'Обработка' THEN 1
//                                WHEN 'Открытый' THEN 2
//                                WHEN 'Активный' THEN 3
//                                WHEN 'Закрытый' THEN 4
//                                ELSE 5
//                                END")
        $projects = Project::orderBy('state_id')
            ->orderBy('id','desc')
            ->select('id','title','user_id','state_id')
            ->paginate(100);
        return view('admacc/projects',compact('projects'));
    }

    /*
     * Страница управления руководителями
     */

    public function admacc_supervisors() {
        $supervisors = User::where('role','supervisor')->select('id','fio','email')->orderBy('id','desc')->paginate(100);
        return view('admacc/supervisors',compact('supervisors'));
    }

    /*
     * Страница справочника тегов
     */

    public function admacc_tags() {
        $tags = Tag::paginate(100); // пагинация тегов по 100 штук на страницу
        return view('admacc/tags',compact('tags')); // возврат шаблона с переданными тегами
    }

    /*
     * Добавление тега
     */

    public function admacc_tag_add(Request $request) {
        $request->validate([
            'tag_add'=>'required',
        ]); // валидация на то, что поле тег заполнено
        $tag = Tag::where('tag',$request->tag_add)->first(); // найти уже существующий тег с указанным именем
        if ($tag) { // если есть тег
            return redirect()->back()->with('error','Тег с именем "'.$request->tag_add.'" уже существует в базе');
        }
        Tag::create([
            'tag'=>$request->tag_add
        ]);
        return redirect()->back()->with('success','Тег '.$request->tag_add.' успешно добавлен');
    }

    /*
     * Удаление тега
     */

    public function admacc_tag_delete($tag_id) {
        $tag = Tag::find($tag_id);
        if (!$tag)
            return redirect()->back()->with('error','Тега с таким ID не существует');
        $tag->delete();
        return redirect()->back()->with('success','Вы успешно удалили тег "'.$tag->tag.'"');
    }

    /*
     * Регистрация руководителя
     */

    public function admacc_registerSupervisor(RegisterSupervisorRequest $request) {
        User::create (
            [
                'username' => $request->login,
                'password' => Hash::make($request->s_password),
                'fio'=> $request->s_fio,
                'email'=> $request->s_email,
                'position'=> $request->position
            ]
        );
        return redirect()->back()->with('success','Руководитель успешно создан');
    }

    /*
     * Показать одну карточку проекта из ЛК
     */

    public function admacc_project_show($id) {
        $project = Project::find($id);
        if (!$project)
            return redirect()->back()->with('error','Проекта с таким ID не существует');
        return view('admacc.showproject',compact('project'));
    }

    /*
     * Удаление руководителя
     */

    public function admacc_supervisor_delete($supervisor_id) {
            $supervisor = User::find($supervisor_id);
            if (!$supervisor)
                return redirect()->back()->with('error','Проекта с таким ID не существует');
            $supervisor->delete();
            return redirect()->back()->with('success','Вы успешно удалили руководителя "'.$supervisor->fio.'"');
    }

    /*
     * Редактирование руководителя (страница показа)
     */

    public function admacc_supervisor_edit($supervisor_id) {
        $supervisor = User::findOrFail($supervisor_id);
        return view('admacc.showsupervisor',compact('supervisor'));
    }

    /*
     * Редактирование руководителя
     */

    public function admacc_supervisor_update(Request $request, $supervisor_id) {
        $request->validate([
            's_fio'=>'required|max:191',
            'username'=>'required|max:191',
            's_email'=>'required|max:191',
            'position'=>'required|max:191'
        ]); // встроенная (не вынесенное в отдельный request) валидация
        $supervisor = User::findOrFail($supervisor_id);
        $oldSupervisorFio = $supervisor->fio;
        $supervisor->fio = $request->s_fio;
        $supervisor->username = $request->username;
        if (!empty($request->s_password))
            $supervisor->password = Hash::make($request->s_password);
        $supervisor->email = $request->s_email;
        $supervisor->position = $request->position;
        $supervisor->save();
        return redirect()->route('admacc_supervisors')->with('success', 'Руководитель "' . $oldSupervisorFio . '" успешно отредактирован');
    }

    public function admacc_expertise() {
        $projects = Project::where('state_id',State::where('state','Обработка')->first()->id)
            ->where('is_scanned',0)->orderBy('updated_at','desc')->paginate(15);
        return view('admacc/expertise',compact('projects'));
    }
}
