<article @if($project->state_name == "Закрытый") class="article_close article_pseudo" @endif>
    @if($project->state_name == "Открытый")
        <div class="article__open">Набор открыт</div>
    @endif
    @if($project->state_name == "Активный")
        <div class="article__active">В разработке</div>
    @endif

    @if($project->state_name == "Закрытый")
{{--        <div>--}}
{{--            <div class="article_tooltip-close"><div class="cross"></div>Нажмите, чтобы<br> раскрыть</div>--}}
{{--        </div>--}}
    @endif
    @if (Auth::user())
        @if (($project->user_id == Auth::user()->id) && !($project->state_name == "Закрытый") && !($project->state_name == "Обработка"))
    <a href="{{  route('assign', ['projectId'=>$project->id]) }}" class="article__assign article__manage"><img src="/images/assignIcon.svg" alt=""></a>
    <a href="{{  route('editProject', ['projectId'=>$project->id]) }}" class="article__edit article__manage"><img src="/images/editIcon.svg" alt=""></a>
    <a href="{{  route('shutProject', ['projectId'=>$project->id]) }}" class="article__delete article__manage"><img src="/images/deleteIcon.svg" alt=""></a>
        @endif
        @if (Auth::user() && Auth::user()->role == 'admin')
            <div class="article__adm-delete article__manage"><img src="/images/deleteIcon.svg" alt=""></div>
        @endif
    @endif
    @if ($project->state_name == "Обработка" && $project->is_scanned == 0)
        <div class="article__handling">На обработке</div>
    @endif
    @if($project->state_name == "Закрытый")
        <div style="height:8px;"></div>
        <div class="article__result blocked">
            <div class="article__result-title">Результат</div>
            <div class="article__result-text">{{ $project->result }}</div>
        </div>
    @else
        @if (!(empty($project->error_message)) && ($project->is_scanned == 1))
            <div class='article__status article__status_error'>Отрицательная экспертиза</div>
{{--        @else--}}
{{--            <div class='article__status'>{{ $project->state_name }}</div>--}}
        @endif
    @endif
    <div class='article__top-wrap'>
        <div class='article__top-left'>
            <div class='article__title'> @if(!request()->has('search')) {!! \AppHelper::truncate($project->title) !!} @else {!! $project->title !!} @endif</div>
        </div>
        <div class='article__top-right'>
            <div class='article__boss'>{{ preg_replace('~^(\S++)\s++(\S)\S++\s++(\S)\S++$~u', '$1 $2.$3.', $project->user_name) }}</div>
        </div>
    </div>
    <p><b>Заказчик:</b> {!! \AppHelper::truncate_break($project->customer,50) !!}</p>
    <p><b>Цель:</b> {!! \AppHelper::truncate_break($project->goal,127) !!}</p>
    <p><b>Идея проекта:</b> {!! \AppHelper::truncate_break($project->idea,112) !!}</p>
    <p><b>Требования к участникам:</b> {!! \AppHelper::truncate_break($project->requirements,42) !!}</p>
    <p><b>Сроки реализации:</b> {{ date('j.m.y', strtotime($project->date_start)) }} – {{ date('j.m.y', strtotime($project->date_end)) }}</p>
    <div class='article__link-wrap'>
        <a class='article__link button button_blue' href="{{ route('showProject',['projectId'=>$project->id]) }}">Подробнее</a>
    </div>
    <p class="article__type">{{ $project->type_name }}</p>
    <div class="article__tags">
        @if(!$project->tags->isEmpty())
            @foreach($project->tags as $tag)
                <span class="article__tag">{{ $tag->tag }}</span>
            @endforeach
        @else
            <span class="article__tag">Теги отсутствуют</span>
        @endif
    </div>
    <div class="article__total-places post-body__places-block">
        Всего мест: {{ $project->places }}
    </div>
    @if (Auth::user() && Auth::user()->role == 'admin')
        <div class="article__control-block">
            <div style="right: 5px;border-radius: 30%;background-color: #C4C2C2;" class="cross"></div>
            @if ($project->state_name == "Закрытый")
                <div style="text-align:center">
                    <a href=" {{ route('admdeleteProject',['projectId'=>$project->id]) }}" class="article__control-block-delete-button">Удалить</a>
                </div>
            @else
                <a href=" {{ route('admshutProject',['projectId'=>$project->id]) }}" class="article__control-block-close-button">Закрыть</a>
                <a href=" {{ route('admdeleteProject',['projectId'=>$project->id]) }}" class="article__control-block-delete-button">Удалить</a>
            @endif
        </div>
    @endif
    @if (Auth::user())
        @if (($project->user_id == Auth::user()->id) && !(empty($project->error_message)) && ($project->is_scanned == 1))
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
</article>
