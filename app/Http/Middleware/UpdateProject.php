<?php

namespace App\Http\Middleware;

use App\Project;
use Closure;
use Illuminate\Support\Facades\Auth;

class UpdateProject
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $project = Project::find($request->route('projectId'));
        if ($project)
            if (($project->user_id == Auth::user()->id) && !($project->state_name == "Закрытый") && (!($project->state_name == "Обработка") || !(empty($project->error_message))))
                return $next($request);
        return redirect('/');
    }
}
