@extends('layouts.master')

@section('title','Управление заявками')

@section('content')
    <ul style="margin-bottom:30px;margin-top:-10px;" class="nav-panel main-content__nav-panel col-md-6">
        <li class="nav-panel__item">
            <a class="nav-panel__link" href="/">Главная</a>
            <img class="nav-panel__nav-elem" src="/images/nav-elem.svg">
        </li>
        <li class="nav-panel__item">
            <a class="nav-panel__link" href="{{ route('showProject',['projectId'=>$project->id]) }}">Карточка проекта</a>
            <img class="nav-panel__nav-elem" src="/images/nav-elem.svg">
        </li>
        <li class="nav-panel__item">
            <a class="nav-panel__link" href="{{ route('assign',['projectId'=>$project->id]) }}">Управление заявками</a>
            <img class="nav-panel__nav-elem" src="/images/nav-elem.svg">
        </li>
    </ul>
    <div class="col-md-7">
        <div class="assigned-project">{{ $project->title }}</div>
        @include('messages.error')
        @include('messages.success')
        <div class="orders-title">Заявки на участие</div>
        <a @if(request()->has('watched')) href="{{ route('assign',['projectId'=>$project->id]) }}"
            @else href="{{ route('assign',['projectId'=>$project->id,'watched'=>'1']) }}"
          @endif class="watchToggle">
            <span class="watchToggle__text">Просмотренные</span>
            <input class="checkbox" name='' type='checkbox' @if(request()->has('watched')) checked @endif>
            <span class="checkmark"></span>
        </a>
        @foreach($candidates as $candidate)
            @include('layouts.candidate-card')
        @endforeach
        {{ $candidates->appends($_GET)->links() }}
    </div>
    <div style="margin-top:-4px;" class="col-md-4">
        <div class="assign-title">Назначение исполнителей</div>
        @if(session()->has('assign-error'))
            <div class="assign-error">
                {{ session()->get('assign-error') }}
            </div>
        @endif
        <div style="margin-bottom:20px;" class="performers">
            <?php
            /*
             * Узнать количество участников
             * $count возвращает количество участников данного проекта
             */
            use App\Candidate;
            $mates = null;
            $count = 0;
            $candidates = Candidate::where('project_id',$project->id)->get();
            foreach($candidates as $candidate) {
                if (($project->id == $candidate->project_id) && ($candidate->is_mate == 1)) {
                    $mates[] = $candidate;
                    $count++;
                }
            }?>
            <div class="performers__title">Выбранные исполнители <span class="performers__places"><b style="color:#477100"><?=$count?></b> из <b>{{ $project->places }}</b></span></div>
            <?php
            for($i=1;$i<=$count;$i++): ?>

            <div class="performers__item">
                <div class="performers__number"><?=$i?>.</div>
                <input type="text" class="performers__field" value="<?php echo array_key_exists($i-1,$mates) ? preg_replace('~^(\S++)\s++(\S)\S++\s++(\S)\S++$~u', '$1 $2.$3.', $mates[$i-1]->fio) : null?>" disabled>
                <a href="{{ route('detachMate',['projectId'=>$project->id,'candidateId'=>$mates[$i-1]->id]) }}" class="performers__delete">
                    <svg class="performers__delete-icon" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0.444336 1L7.66655 8M14.8888 15L7.66655 8M7.66655 8L0.444336 15M7.66655 8L14.8888 1" stroke="#636363" stroke-linejoin="round"/>
                    </svg>
                </a>
            </div>
            <?php endfor; ?>
                @if ($project->state_name == "Открытый")
                    <div class="performers__assume performers__assume_disabled">Возобновить<br> прием заявок</div>
                @else
                    <a href="{{ route('resumeAccepting',['projectId'=>$project->id]) }}" class="performers__assume">Возобновить<br> прием заявок</a>
                @endif
                @if ($project->state_name == "Активный")
                    <div class="performers__suspend performers__assume performers__assume_disabled">Приостановить<br> прием заявок</div>
                @else
                    <a href="{{ route('suspendAccepting',['projectId'=>$project->id]) }}" class="performers__suspend performers__assume">Приостановить<br> прием заявок</a>
                @endif
                    <div class="performers__edit-text">Изменить кол-во<br> мест на</div>
                    <form class="performers__edit-form" action="{{ route('changePlaces',['projectId'=>$project->id]) }}" method="GET">
                        <input name="places" type="number" class="performers__edit-input" value="<?=$project->places?>">
                        <button class="performers__edit-submit" type="submit"><img src="/images/rotate.svg"></button>
                    </form>
        </div> <!-- performers -->
        <ul class="advice">
            <li class="advice__item">
                При нажатии на кнопку “Запретить прием заявок” студенты не смогут подавать заявки на участие в проекте
            </li>
            <li class="advice__item">
                Если вы хотите изменить количество участников и возобновить прием заявок - нажмите на кнопку “Возобновить прием заявок”
            </li>
        </ul>
    </div>

@endsection
