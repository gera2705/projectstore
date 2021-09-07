<div class="row">
    <div class="open-project @if(!Route::is('admacc_expertise'))col-md-8 @endif">
        <div @if(!empty($project->error_message)) style="background: linear-gradient(128.61deg, #636363 2.78%, rgba(203, 203, 203, 0) 3.32%);" @endif class="open-project__card-wrap">
            <div class="open-project__id">{{ $project->id }}</div>
            <div class="open-project__supervisor">{{ preg_replace('~^(\S++)\s++(\S)\S++\s++(\S)\S++$~u', '$1 $2.$3.', $project->user->fio) }}</div>
            <div class="open-project__title">{{ \AppHelper::truncate($project->title) }}</div>
        </div>
        <a href="{{ route('expertiseProject',['projectId'=>$project->id]) }}" class="open-project__show button button_blue">Подробнее</a>
        <a href="#" class="open-project__approval button button_blue">Одобрение</a>
    </div>
</div>
