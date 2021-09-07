<?php

namespace App\Http\Middleware;

use App\Project;
use Closure;

class CheckForOpenProject
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
        if($project)
            if($project->state_name == "Открытый")
                return $next($request);
        return redirect('/');
    }
}
