@extends('layouts.admacc-master')

@section('title','Карточка проекта')

@section('content')
    <div style="padding-left:20px;">
        <div class="properties participation-form">
            <a style="font-family: 'Montserrat',sans-serif;border-width: 1px;margin-bottom: 15px;margin-top: -6px;font-weight:500" href="{{ url()->previous() }}" class="button">Вернуться</a>
            <div style="padding-left: 0;" class="assigned-project">{{ $project->title }}</div>
            @csrf
            <div style="text-decoration:underline;">{{ $project->state_name }}</div>
            <div class="participation-form__row properties__item properties__item_addproject properties__item_closeproject">
                <span class="properties__head">Руководитель проекта</span>
                <span class="properties__desc">{{ $project->user->fio }}</span>
            </div>
            <div class="participation-form__row properties__item properties__item_addproject properties__item_closeproject">
                <span class="properties__head">Тип проекта</span>
                <span class="properties__desc">{{ $project->type->type }}</span>
            </div>
            <div class="participation-form__row properties__item properties__item_addproject properties__item_closeproject">
                <span class="properties__head">Цель проекта</span>
                <span class="properties__desc">{{ $project->goal }}</span>
            </div>
            <div class="participation-form__row properties__item properties__item_addproject properties__item_closeproject">
                <span class="properties__head">Идея проекта</span>
                <span class="properties__desc">{{ $project->idea }}</span>
            </div>
            <div class="participation-form__row properties__item properties__item_addproject properties__item_closeproject">
                <span class="properties__head">Сроки реализации</span>
                <span class="properties__desc">{{ date('j.m.y', strtotime($project->date_start)) }} – {{ date('j.m.y', strtotime($project->date_end)) }}</span>
            </div>
            <div class="participation-form__row properties__item properties__item_addproject properties__item_closeproject">
                <span class="properties__head">Требования к участникам</span>
                <span class="properties__desc">{{ $project->requirements }}</span>
            </div>
            <div class="participation-form__row properties__item properties__item_addproject properties__item_closeproject">
                <span class="properties__head">Заказчик</span>
                <span class="properties__desc">{{ $project->customer }}</span>
            </div>
            <div class="participation-form__row properties__item properties__item_addproject properties__item_closeproject">
                <span class="properties__head">Ожидаемый результат</span>
                <span class="properties__desc">{{ $project->expected_result }}</span>
            </div>
            @if(!empty($project->additional_inf))
                <div class="participation-form__row properties__item properties__item_addproject properties__item_closeproject">
                    <span class="properties__head">Дополнительная информация</span>
                    <span class="properties__desc">{{ $project->additional_inf }}</span>
                </div>
            @endif
            <div class="participation-form__row properties__item properties__item_addproject properties__item_closeproject">
                <span class="properties__head">Теги</span>
                <span class="properties__desc">
                <?php
                    $tagsCount = $project->tags->count();
                    $i = 0;
                    for($i = 0;$i<$tagsCount;$i++) {
                        if ($i != $tagsCount-1)
                            echo $project->tags[$i]->tag . ", ";
                        else
                            echo $project->tags[$i]->tag;
                    }
                    ?>
            </span>
            </div>
            <div class="participation-form__row properties__item properties__item_addproject properties__item_closeproject">
                <span class="properties__head">Общее кол-во мест</span>
                <span class="properties__desc">{{ $project->places }}</span>
            </div>
            @if(!empty($project->result))
                <div style="color:#1D69DA;" class="participation-form__row properties__item properties__item_addproject properties__item_closeproject">
                    <label for="result" class="properties__head">Результат</label>
                    <span class="properties__desc">{{ $project->result }}</span>
                </div>
            @endif
        </div>
    </div>
@endsection
