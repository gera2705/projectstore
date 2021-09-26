<?php

namespace App\Http\Controllers;

use App\Candidate;
use App\Http\Requests\CandidateStoreRequest;
use App\Project;
use App\User;
use Illuminate\Support\Facades\Mail;
use App\Jobs\SendMail;


class CandidateController extends Controller
{
    /*
     * Функция создания карточки кандидата
     */
    public function store (CandidateStoreRequest $request,$project_id) {
        $project = Project::where('id',$project_id)->first(); // найти проект с переданным ID
        $candidate = Candidate::create([
            'fio'=>$request->fio,
            'email'=>$request->email,
            'phone'=>$request->phone,
            'competencies'=>$request->competencies,
            'course'=>$request->course,
            'training_group'=>$request->training_group,
            'experience'=>$request->experience,
            'project_id'=>$project_id,
            'is_mate'=>0,
        ]);

        $supervisorEmail = User::where('id',$project->user_id)->first()->email;
        SendMail::dispatch($supervisorEmail,$project,$candidate);
     //   Mail::to($supervisorEmail)->queue(new \App\Mail\CandidateOrderMail($project,$candidate));
        return redirect()->route('index')->with('success', 'Ваша заявка была успешно отправлена, ожидайте ответа руководителя');
    }

    /*
     * Назначить в качестве исполнителя
     */

    public function assignMate($project_id,$candidate_id) {
        $candidate = Candidate::findOrFail($candidate_id);
        if ($candidate->is_mate == 1)
            return redirect()->back();
        $project = Project::findOrFail($project_id);
        if (($project->places - $project->candidates()->where('is_mate',1)->count()) <= 0)
            return redirect()->back()->with('assign-error','Превышен лимит мест');
        $candidate->is_mate = 1;
        $candidate->is_watched = 0;
        $candidate->save();
        return redirect()->back();
    }

    /*
     * Убрать в качестве исполнителя
     */

    public function detachMate($project_id,$candidate_id) {
        $candidate = Candidate::findOrFail($candidate_id);
        if ($candidate->is_mate == 0)
            return redirect()->back();
        $candidate->is_mate = 0;
        $candidate->save();
        return redirect()->back();
    }

    /*
     * Изменение состояния на "не просмотрено"
     */

    public function unwatch($project_id,$candidate_id) {
        $candidate = Candidate::findOrFail($candidate_id);
        if ($candidate->is_watched == 0)
            return redirect()->back();
        $candidate->is_watched = 0;
        $candidate->save();
        return redirect()->back();
    }

    /*
     * Изменение состояния на просмотрено
     */

    public function watch($project_id,$candidate_id) {
        $candidate = Candidate::findOrFail($candidate_id);
        if ($candidate->is_watched == 1)
            return redirect()->back();
        $candidate->is_watched = 1;
        $candidate->save();
        return redirect()->back();
    }

}
