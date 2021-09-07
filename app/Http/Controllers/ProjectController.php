<?php

namespace App\Http\Controllers;

use App\Candidate;
use App\Http\Requests\ProjectEditRequest;
use App\Http\Requests\ProjectStoreRequest;
use App\Jobs\SendProjectCreatedMail;
use App\Project;
use App\State;
use App\Tag;
use App\Type;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $types = Type::all();
        $tags = Tag::all();
        return view('supervisor/add', compact('types','tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProjectStoreRequest $request)
    {
        if (count($request->tags) > 5) {
            //     return redirect()->back()->withErrors(['tags'=>'Количество тегов не больше быть больше пяти']);
            return redirect()->back()->withInput()->withErrors(['tags' => 'Количество тегов не может быть больше пяти']);
        }
        $project = Project::create(
            [
                "title" => $request->title,
                "places" => $request->places,
                "state_id" => State::where('state','Обработка')->first()->id,
                "type_id" => Type::where('type',$request->type_id)->first()->id,
                "goal" => $request->goal,
                "idea" => $request->idea,
                "user_id" => Auth::id(),
                "date_start" => $request->date_start,
                "date_end" => $request->date_end,
                "requirements" => $request->requirements,
                "customer" => $request->customer,
                "expected_result" => $request->expected_result,
                "additional_inf" => $request->additional_inf,
            ]
        );
        $project->tags()->sync($request->tags);
        // Здесь должна быть отправка на email
        $admins_email = User::all()->where('role','admin')->map(function ($user) {
            return $user->email;
        })->flatten();



        SendProjectCreatedMail::dispatch($project, $admins_email, Auth::user());
        return redirect()->route('personalcab')->with('success', 'Проект "' . $project->title . '" был успешно создан и отправлен на обработку');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $project = Project::findOrFail($id);
        return view('project', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $project = Project::findOrFail($id);
        $types = Type::all();
        $tags = Tag::all();
        return view('supervisor/edit', compact('project','types','tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProjectEditRequest $request, $id)
    {
        if (count($request->tags) > 5) {
       //     return redirect()->back()->withErrors(['tags'=>'Количество тегов не больше быть больше пяти']);
            return redirect()->back()->withErrors(['tags' => 'Количество тегов не может быть больше пяти']);
        }

        $project = Project::findOrFail($id);
        $oldProjectTitle = $project->title;
        $newValues = $request->except('_method', '_token','type_id','tags');
        foreach($newValues as $key => $value)
        {
            $project[$key] = $value;
        }
        if (!($project->state_name == "Обработка" && $project->is_scanned == 1 && !empty($project->error_message)))
            $project->title = $oldProjectTitle;
        $project['type_id'] = Type::where('type',$request->type_id)->first()->id;
        $project->tags()->sync($request->tags);
        if ($project->state_name == "Обработка") {
            $project->is_scanned = 0;
//            $project->error_message = null;
        }
        $project->updated_at = $project->freshTimestamp();
        $project->save();
        return redirect()->route('personalcab')->with('success', 'Ваш проект "' . $project->title . '" успешно отредактирован');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $project = Project::find($id);
        if (!$project)
            return redirect()->back()->with('error','Проекта с таким ID не существует');
        $projectTitle = $project->title;
        $project->delete();
        return redirect()->back()->with('success','Вы успешно удалили проект "'.$projectTitle.'"');
    }


    /*
     * Страница отправки заявки на участие
     */

    public function participate($id) {
        $project = Project::findOrFail($id); // Найти проект по ID
        return view('participation',compact('project'));
    }

    /*
     * Страница назначения исполнителей
     */

    public function assign(Request $request,$id) {
        if ($request->has('watched')) // если есть GET-параметр watched, то мы просмотренных выдаем, если нет иначе
            $candidates = Candidate::where('project_id',$id)->where('is_watched',1)->orderBy('id','desc')->paginate(9);
        else
            $candidates = Candidate::where('project_id',$id)->where('is_watched',0)->orderBy('id','desc')->paginate(9);
        $project = Project::findOrFail($id);
        return view('supervisor/assign',compact('candidates','project'));
    }

    /*
     * Страница закрытия проекта
     */

    public function shut(int $id) {
        $project = Project::findOrFail($id); // Найти проект по ID
        return view('supervisor/close',compact('project'));
    }

    /*
     * Логика закрытия проекта
     */

    public function close(Request $request, $id)
    {
        $request->validate([
            'result' => 'required|max:300'
        ]);
        $project = Project::find($id); // Найти проект по ID
        $project->result = $request->result;
        $project->state_id = State::where('state','Закрытый')->first()->id;
        $project->save();
        if (Auth::user()->role == 'supervisor')
            return redirect()->route('personalcab')->with('success', 'Ваш проект "' . $project->title . '" успешно закрыт');
        else
            return redirect()->route('index')->with('success','Проект "' . $project->title . '" успешно закрыт');
    }

    /*
     * Функция возобновления приема заявок --> "Возобновить прием заявок"
     */

    public function resumeAccepting($project_id) {
        $project = Project::findOrFail($project_id);
        if ($project->state_name == "Открытый")
            return redirect()->back();
        $project->state_id = State::where('state','Открытый')->first()->id;
        $project->save();
        return redirect()->back()->with('success', 'Вы успешно возобновили прием заявок');
    }

    /*
     * Функция приостановления приема заявок --> "Приостановить прием заявок"
     */

    public function suspendAccepting($project_id) {
        $project = Project::findOrFail($project_id);
        if ($project->state_name == "Активный")
            return redirect()->back();
        $project->state_id = State::where('state','Активный')->first()->id;
        $project->save();
        return redirect()->back()->with('success', 'Вы успешно приостановили прием заявок');
    }

    /*
     * Изменение мест в проекте
     */

    public function changePlaces(Request $request,$project_id) {
        $project = Project::findOrFail($project_id);
        $places = $request->places;
        if ($places == 0)
            return redirect()->back()->with('error','Мест не может быть 0');
        if ($places < 0)
            return redirect()->back()->with('error','Мест не может быть меньше нуля');
        if ($project->places == $places)
            return redirect()->back()->with('error','Вы не можете изменить на текущее кол-во мест');
        if (!ctype_digit($places))
            return redirect()->back()->with('error','Введенное значение не является целым числом');
        if ($places > 100)
            return redirect()->back()->with('error','Превышен лимит мест (не больше 100)');
        if ($project->candidates()->where('is_mate',1)->count() > $places)
            return redirect()->back()->with('error','Сначала необходимо убрать участников, а затем присвоить меньшее кол-во мест');
        $project->places = $places;
        $project->save();
        return redirect()->back()->with('success','Вы успешно изменили кол-во мест на '.$places);
    }
}
