<?php

namespace App\Http\Middleware;

use App\Project;
use Closure;
use Illuminate\Support\Facades\Auth;

class ProtectPages
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    // Используется для защиты от управления не своим проектом
    public function handle($request, Closure $next)
    {
        $project = Project::find($request->route('projectId'));
        // если проект существует и он принадлежит пользователю и он не закрыт и он не обработан, то разрешаем доступ
        if ($project)
            if (($project->user_id == Auth::user()->id) && !($project->state_name == "Закрытый") && !($project->state_name == "Обработка"))
                return $next($request);
        return redirect('/');
    }
}
