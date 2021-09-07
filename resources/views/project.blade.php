@extends('layouts.master')

@section('title','Карточка проекта')

@section('content')
    <ul style="margin-left:-8px" class="nav-panel main-content__nav-panel col-md-6">
        <li class="nav-panel__item">
            <a class="nav-panel__link" href="/">Главная</a>
            <img class="nav-panel__nav-elem" src="/images/nav-elem.svg">
        </li>
        <li class="nav-panel__item">
            <a class="nav-panel__link" href="{{ route('showProject',['projectId'=>$project->id]) }}">Карточка проекта</a>
        </li>
    </ul>
</div> <!-- row -->
<div class="row">
    <div class="col-md-6">
        <div class="post-title">
            {{ $project->title }}
        </div>
    </div>
</div> <!-- row -->
<div class="row">
    <div style="padding-bottom:70px;" class="col-md-7">
        <div class="post-body">
            @if (Auth::user())
                @if (($project->user_id == Auth::user()->id) && !($project->state_name == "Закрытый") && !($project->state_name == "Обработка"))
                    <a href="{{ route('shutProject',['projectId'=>$project->id]) }}" class="post-body__close">Закрыть проект</a>
                    <a href="{{ route('editProject',['projectId'=>$project->id]) }}" class="editProject">Изменить</a>
                    <a href="{{ route('assign',['projectId'=>$project->id]) }}" class="assignPerformers">Назначить<br> исполнителей</a>
                @endif
            @endif
            @if ($project->state_name == "Обработка" && $project->is_scanned == 0)
                <div class="article__handling">На обработке</div>
            @endif
            @if ($project->state_name == "Закрытый")
                <div style="height:22.22px;"></div>
                <div class="article__result blocked">
                    <div class="article__result-title">Результат</div>
                    <div class="article__result-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Deserunt dolore dolorum quis. Aperiam architecto delectus dolor ducimus esse, harum in iusto maxime, natus quas sequi ut vero vitae voluptatem voluptatibus!</div>
                </div>
            @else
                @if (!(empty($project->error_message)) && ($project->is_scanned == 1))
                    <div class='post-body__state article__status_error'>Отрицательная экспертиза</div>
                @else
                    <div class='post-body__state'>{{ $project->state_name }}</div>
                @endif
            @endif
            @if ($project->state_name == "Открытый")
                <div class="post-body__places-block">
                    Вакантных мест: <span style="color:#3057BB">{{ $project->places - $project->candidates()->where('is_mate',1)->count() }}</span></b>
                </div>
            @endif
            <ul class="properties">
                <li class="properties__item">
                    <span class="properties__head">Руководитель проекта</span>
                    <span class="properties__desc">{{ $project->user->fio }}</span>
                </li>
                <li class="properties__item">
                    <span class="properties__head">Тип проекта</span>
                    <span class="properties__desc">{{ $project->type->type }}</span>
                </li>
                <li class="properties__item">
                    <span class="properties__head">Цель проекта</span>
                    <span class="properties__desc">{!! $project->goal !!}</span>
                </li>
                <li class="properties__item">
                    <span class="properties__head">Идея проекта</span>
                    <span class="properties__desc">{!! $project->idea !!}</span>
                </li>
                <li class="properties__item">
                    <span class="properties__head">Сроки реализации</span>
                    <span class="properties__desc">{{ date('j.m.y', strtotime($project->date_start)) }} – {{ date('j.m.y', strtotime($project->date_end)) }}</span>
                </li>
                <li class="properties__item">
                    <span class="properties__head">Требования к участникам</span>
                    <span class="properties__desc">{!! $project->requirements !!}</span>
                </li>
                <li class="properties__item">
                    <span class="properties__head">Заказчик</span>
                    <span class="properties__desc">{!! $project->customer !!}</span>
                </li>
                <li class="properties__item">
                    <span class="properties__head">Ожидаемый результат</span>
                    <span class="properties__desc">{!! $project->expected_result !!}</span>
                </li>
                @if(!empty($project->additional_inf))
                    <li class="properties__item">
                        <span class="properties__head">Дополнительная информация</span>
                        <span class="properties__desc">{!! $project->additional_inf !!}</span>
                    </li>
                @endif
            </ul>
            @if ($project->state_name == "Открытый")
                @if (Auth::user() == null || !($project->user_id == Auth::user()->id))
    {{--                <div class="participation-link mask-participation-link"></div>--}}
                    <a class="participation-link" href="{{ route('participation',['projectId'=>$project->id]) }}">Оставить заявку<br> на участие</a>
                @endif
            @endif
            @if (Auth::user())
                @if (($project->user_id == Auth::user()->id) && !(empty($project->error_message)))
                    <div class="rejection-block">
                        <div class="cross"></div>
                        <div class="rejection-block__title">Причина отклонения</div>
                        <div class="rejection-block__text">{{ $project->error_message }}</div>
                        <div style="text-align:center;">
                            <a href="{{ route('editProject',['projectId'=>$project->id]) }}" class="rejection-block__edit">Исправить</a>
                        </div>
                    </div>
                @endif
            @endif
        </div>
    </div> <!-- col-md-6 -->

@endsection
