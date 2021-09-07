@extends('layouts.master')

@section('title','Подробная экспертиза')

@section('content')
<div class="row">
    <div class="properties participation-form col-md-7" action="{{ route('rejectProject',['projectId'=>$project->id]) }}" method="post">
        <a style="font-family: 'Montserrat',sans-serif;border-width: 1px;margin-bottom: 15px;margin-top: -6px;font-weight:500" href="{{ url()->previous() }}" class="button">Вернуться</a>
        <input name="project_id" type="hidden" value="{{ $project->id }}">
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
        @if(!empty($project->error_message))
            <div style="color:#ff442b" class="participation-form__row properties__item properties__item_addproject properties__item_closeproject">
                <span class="properties__head">Причина отказа</span>
                <span class="properties__desc">{{ $project->error_message }}</span>
            </div>
        @endif
{{--        <div class="participation-form__row properties__item properties__item_addproject properties__item_closeproject">--}}
{{--            <label for="error_message" class="properties__head">Отказать по причине</label>--}}
{{--            <div>--}}
{{--                @error('error_message')--}}
{{--                    <div class="error">{{ $message }}</div>--}}
{{--                @enderror--}}
{{--                <textarea class='participation-form__input-field' type='text' name="error_message" id="error_message"></textarea>--}}
{{--            </div>--}}
{{--        </div>--}}
        <div class="participation-form__row properties__item properties__item_addproject properties__item_closeproject">
            <div>
                <a style="border-color: #40AE87;color: #40AE87;" href="{{ route('approveProject',['projectId'=>$project->id]) }}" class="button button_closeproject button_closeproject-cancel">Одобрить</a>
            </div>
            <div>
                <a id="rejectLink" href="#" style="border-color: #FF5942;color: #FF5942;" class="button button_closeproject participation-form__submit button_closeproject-cancel" type="submit">Отклонить</a>
            </div>
        </div>
        <div style="left:216px;" class="approval-form">
            <div class="cross"></div>
            <form action="{{ route('rejectProject') }}" class="approval-form__rejection-form" method="POST">
                @csrf
                <div class="approval-form__rejection-form-title">Причина отклонения</div>
                <input name="project_id" type="hidden" value="{{ $project->id }}">
                <div>
                    <textarea name="error_message" cols="17" rows="4" required></textarea>
                </div>
                <button class="approval-form__rejection-form-submit approval-form__approve" type="submit">Отклонить</button>
            </form>
        </div>
    </div>
@endsection
