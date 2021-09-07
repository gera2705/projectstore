@extends('layouts.master')

@section('title','Закрытие проекта')

@section('content')
    <ul class="nav-panel main-content__nav-panel col-md-5">
        <li class="nav-panel__item">
            <a class="nav-panel__link" href="/">Главная</a>
            <img class="nav-panel__nav-elem" src="/images/nav-elem.svg">
        </li>
        <li class="nav-panel__item">
            <a class="nav-panel__link" href="{{ route('showProject',['projectId'=>$project->id]) }}">Карточка проекта</a>
            <img class="nav-panel__nav-elem" src="/images/nav-elem.svg">
        </li>
        <li class="nav-panel__item">
            <a class="nav-panel__link" href="{{ route('shutProject',['projectId'=>$project->id]) }}">Закрытие проекта</a>
        </li>
    </ul>
</div> <!-- row -->
<div class="row">
    <form class="properties participation-form col-md-7" action="@if (Auth::user()->role=='admin') {{ route('admcloseProject',['projectId'=>$project->id]) }} @else {{ route('closeProject',['projectId'=>$project->id]) }} @endif" method="post">
        <div style="padding-left: 0;" class="assigned-project">{{ $project->title }}</div>
        @csrf
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
            <label for="result" class="properties__head participation-form__label"><span>Результат<img src='/images/participation-star.svg'></span></label>
            <div>
                @error('result')
                    <div class="error">{{ $message }}</div>
                @enderror
                <textarea class='participation-form__input-field' type='text' name="result" id="result"></textarea>
            </div>
        </div>
        <div class="participation-form__row properties__item properties__item_addproject properties__item_closeproject">
            <div>
                <button class="button button_closeproject participation-form__submit" type="submit">Закрыть проект</button>
            </div>
            <div>
                <a href="{{ url()->previous() }}" class="button button_closeproject-cancel button_gray">Отмена</a>
            </div>
        </div>
    </form>
@endsection
