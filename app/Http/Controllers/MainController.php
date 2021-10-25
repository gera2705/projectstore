<?php

namespace App\Http\Controllers;

use App\State;
use App\User;
use Illuminate\Http\Request;
use App\Project;
use App\Tag;
use App\Type;
Use App\Supervisor;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Helpers\AppHelper;


class MainController extends Controller
{
    /*
     * Главная страница с написанной логикой поиска через GET-параметры
     */

    public function index(Request $request) {
        $supervisors = User::where('role','supervisor')->get();
        $tags = Tag::all();
        $types = Type::all();
        $projectsQuery = Project::query();
        $projectsQuery->join('states','states.id','=','projects.state_id')
            ->where('states.state','!=','Обработка');

        // Create an empty array
        // if request has a type_id then need this id into array
        // after array is completed, filter this via WhereIn

        $filteredTags = null;
        $filteredTypes = null;
        $filteredSupervisors = null;
        $filteredStates = null;

        if ($request->filled('search')) {
            $keyword = $request->search;
            $projectsQuery->where('title', 'LIKE', "%$keyword%");
        }

        foreach (['Открытый','Активный','Закрытый'] as $state) { // ???
            if ($request->has($state))
                $filteredStates[] = $state;
        }

        foreach ($types as $type) {
            if ($request->has($type->type))
                $filteredTypes[] = $type->id;
        }

        foreach ($supervisors as $supervisor) {
            if ($request->has(str_replace(" ","_",$supervisor->fio)))
                $filteredSupervisors[] = $supervisor->id;
        }

        foreach ($tags as $tag) {
            if ($request->has($tag->tag))
                $filteredTags[] = $tag->id;
        }

        if ($filteredStates != null) {
            $projectsQuery->whereIn('states.state',$filteredStates);
        }

        if ($filteredTags != null) {
            $projectsQuery->whereHas('tags', function ($q) use ($filteredTags) {
                $q->whereIn('id',$filteredTags);
            });
        }


        if ($filteredSupervisors != null)
            $projectsQuery->whereIn('user_id', $filteredSupervisors);

        if ($filteredTypes != null)
            $projectsQuery->whereIn('type_id', $filteredTypes);


        if ($request->filled('date_start')) {
            $date_start = Carbon::parse($request->date_start);
            $projectsQuery->whereDate('date_start', '>=', $date_start);
        }

        if ($request->filled('date_end')) {
            $date_end = Carbon::parse($request->date_end);
            $projectsQuery->whereDate('date_end','<=',$date_end);
        }


//        $projects = $projectsQuery->paginate(4)->withPath("?" . $request->getQueryString());
        $projects = $projectsQuery
//            ->orderByRaw("CASE state
//                                WHEN 'Открытый' THEN 1
//                                WHEN 'Активный' THEN 2
//                                WHEN 'Закрытый' THEN 3
//                                ELSE 4
//                                END")
               // ->orderBy('state_id')

            ->orderBy('states.id', 'asc')->select('projects.*')
            ->orderBy('id','desc')
            ->paginate(7);

        if ($request->filled('search')) {
            $projects
                ->map(function ($row) use ($keyword) {
                    AppHelper::truncate($row->title);
                    $row->title = preg_replace('/(' . $keyword . ')/iu', "<b>$1</b>", $row->title);
                    return $row;
                });
        }
        return view('index',compact('projects','tags','types','supervisors'));
    }

    /*
     * Личный кабинет супервайзора с логикой поиска через GET-параметры
     */

    public function personalcab(Request $request) {
        $tags = Tag::all();
        $types = Type::all();
        $projectsQuery = Project::query();
        $projectsQuery->where('user_id',Auth::user()->id);
        $projectsQuery->join('states','states.id','=','projects.state_id');
        // Create an empty array
        // if request has a type_id then need this id into array
        // after array is completed, filter this via WhereIn

        $filteredTags = null;
        $filteredTypes = null;
        $filteredStates = null;

        foreach (['Открытый','Активный','Закрытый','Обработка'] as $state) {
            if ($request->has($state))
                $filteredStates[] = $state;
        }


        foreach ($types as $type) {
            if ($request->has($type->type))
                $filteredTypes[] = $type->id;
        }

        foreach ($tags as $tag) {
            if ($request->has($tag->tag))
                $filteredTags[] = $tag->id;
        }


        if ($filteredStates != null) {
            $projectsQuery->whereIn('states.state',$filteredStates);
        }

        if ($filteredTags != null) {
            $projectsQuery->whereHas('tags', function ($q) use ($filteredTags) {
                $q->whereIn('id', $filteredTags);
            });
        }

        if ($filteredTypes != null)
            $projectsQuery->whereIn('type_id', $filteredTypes);


        if ($request->filled('date_start')) {
            $date_start = Carbon::parse($request->date_start);
            $projectsQuery->whereDate('date_start', '>=', $date_start);
        }

        if ($request->filled('date_end')) {
            $date_end = Carbon::parse($request->date_end);
            $projectsQuery->whereDate('date_end','<=',$date_end);
        }

        $projects = $projectsQuery->select('projects.*')->orderBy('updated_at','desc')->paginate(7);

        return view('supervisor/personalcab',compact('projects','tags','types'));
    }

    /*
     * Страница "Зачем участвовать в проектах"
     */

    public function whyAnswer() {
        return view('why-answer');
    }

}
