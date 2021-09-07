@extends('layouts.master')

@section('title','Редактирование проекта')

@section('content')
    <div class="col-md-7 addedit-title-wrap">
        @if ($errors->any())
            <div class="form-error">Проверьте<br>правильность<br>формы</div>
        @else
            <div style="display:none" class="form-error">Проверьте<br>правильность<br>формы</div>
        @endif
        <div class="addedit-title edit-title">Редактирование проекта</div>
    </div>
</div>
    <div id="title_parent" class="row">
    <div class="edit-project-title col-md-6 assigned-project">{{ \AppHelper::truncate($project->title) }}</div>
    <form class="participation-form col-md-7" action=" {{ route('updateProject',['projectId'=>$project->id]) }}" method="POST">
        @csrf
        @method('PUT')
    <p class='note note_create'><img src="/images/participation-star.svg"> - поля, обязательные к заполнению</p>
    @if($project->state_name == "Обработка" && $project->is_scanned == 1 && !empty($project->error_message))
        <div  class="participation-form__row properties__item properties__item_addproject">
            <label for='title' class="participation-form__label"><span>Название проекта<img src='/images/participation-star.svg'></span></label>
            <div>
                @error('title')
                    <div class="error">{{ $message }}</div>
                @enderror
                <input class='participation-form__input-field' type='text' name='title' id='title' value="{{ old('title', isset($project['title']) ? $project->title : null) }}">
            </div>
        </div>
    @endif
    <div class="participation-form__row properties__item properties__item_addproject">
            <label for='text' class="participation-form__label"><span>Цель проекта<img src='/images/participation-star.svg'></span></label>
        <div>
            @error('goal')
                <div class="error">{{ $message }}</div>
            @enderror
            <textarea class='limit-127 participation-form__input-field' type='text' name='goal' id='goal'>{{ old('goal', isset($project['goal']) ? $project->goal : null) }}</textarea>
        </div>
    </div>
    <div class="participation-form__row properties__item properties__item_addproject">
        <label for='idea' class="participation-form__label"><span>Идея проекта<img src='/images/participation-star.svg'></span></label>
        <div>
            @error('idea')
                <div class="error">{{ $message }}</div>
            @enderror
            <textarea class='limit-112 participation-form__input-field' name='idea' id='idea'>{{ old('idea', isset($project['idea']) ? $project->idea : null) }}</textarea>
        </div>
    </div>
    <div class="participation-form__row properties__item properties__item_addproject">
        <label for='requirements' class="participation-form__label"><span>Требования к<br>участникам<img src='/images/participation-star.svg'></span></label>
        <div>
            @error('requirements')
            <div class="error">{{ $message }}</div>
            @enderror
            <textarea class='limit-42 participation-form__input-field' type='text' name='requirements' id='requirements'>{{ old('requirements', isset($project['requirements']) ? $project->requirements : null) }}</textarea>
        </div>
    </div>
    <div class="participation-form__row properties__item properties__item_addproject">
        <label for='expected_result' class="participation-form__label"><span>Ожидаемый<br>результат<img src='/images/participation-star.svg'></span></label>
        <div>
            @error('expected_result')
                <div class="error">{{ $message }}</div>
            @enderror
            <textarea class='participation-form__input-field' name='expected_result' id='expected_result'>{{ old('expected_result', isset($project['expected_result']) ? $project->expected_result : null) }}</textarea>
        </div>
    </div>
    <div class="participation-form__row properties__item properties__item_addproject">
        <label for='customer' class="participation-form__label"><span>Заказчик<img src='/images/participation-star.svg'></span></label>
        <div>
            @error('customer')
                <div class="error">{{ $message }}</div>
            @enderror
            <textarea class='limit-50 participation-form__input-field' type='text' name='customer' id='customer'>{{ old('customer', isset($project['customer']) ? $project->customer : null) }}</textarea>
        </div>
    </div>
    <div style="position:relative" class="participation-form__row properties__item properties__item_addproject">
        <label class="participation-form__label"><span>Тип проекта<img src='/images/participation-star.svg'></span></label>
        <div class="fieldset participation-form__fieldset fieldset_addproject">
            @error('type_id')
                <div class="error">{{ $message }}</div>
            @enderror
            <p>Тип проекта</p>
            @foreach($types as $type)
                <label>{{ $type->type }}<input name="type_id" type="radio" value="{{ $type->type }}" {{ $project->type->type == $type->type ? 'checked' : '' }}></label>
            @endforeach
        </div>
        <div class="deadline">
            <p>Сроки реализации<img src='/images/participation-star.svg'></p>
            <p>от</p>
            @error('date_start')
                <div class="error">{{ $message }}</div>
            @enderror
            <div>
                <input type="date" name="date_start" value="{{ old('date_start', isset($project['date_start']) ? $project->date_start : null) }}">
            </div>
            <p>до</p>
            @error('date_end')
                <div class="error">{{ $message }}</div>
            @enderror
            <div>
                <input type="date" name="date_end" value="{{ old('date_end', isset($project['date_end']) ? $project->date_end : null) }}">
            </div>
        </div>
    </div>
    <div class="participation-form__row properties__item properties__item_addproject"> <!-- places -->
        <label for='places' class="participation-form__label"><span>Сколько человек<br>требуется<img src='/images/participation-star.svg'></span></label>
        <div>
            @error('places')
                <div class="error">{{ $message }}</div>
            @enderror
            <input class='participation-form__input-field fieldset_addproject' min="1" max="100" type='number' name='places' id='places' value="{{ old('places', isset($project['places']) ? $project->places : null) }}">
        </div>
    </div> <!-- places -->
    <div class="participation-form__row properties__item properties__item_addproject"> <!-- tags -->
        <label class="participation-form__label"><span>Теги проекта<br>(Не больше 5)<img src='/images/participation-star.svg'></span></label>
        <div class="fieldset_wrap">
            @error('tags')
            <div class="error">{{ $message }}</div>
            @enderror
            <div style="width: auto !important; min-width:47%; display:inline-block;" class="fieldset fieldset_select participation-form__fieldset fieldset_addproject">
                <p style="line-height: 27px;">Теги проекта
                    <span class="triangle triangle_line"></span>
                    <span class="fieldset__line"></span>
                </p>
                <?php $flag = 0; if(is_array(old('tags'))) $flag = 1; ?>
                @foreach($tags as $tag)
                    <label>{{ $tag->tag }}
                        <input class="c-limit-5" type="checkbox" name="tags[]" value="{{ $tag->id }}" <?php
                        if(is_array(old('tags')) && in_array($tag->id, old('tags'))) {
                            echo ' checked';
                        }
                        else if($flag == 0) {
                            if($project->tags->contains($tag->id)) echo 'checked=checked';
                            else echo '';
                        }
                        ?>>
                        <span class="checkmark"></span>
                    </label>
                @endforeach
            </div>
        </div>
    </div> <!-- tags -->
    <div class="participation-form__row properties__item properties__item_addproject"> <!-- additional_inf -->
        <label for="additional_inf" class="participation-form__label"><span>Дополнительная информация</span></label>
        <div>
            <textarea class='participation-form__input-field not_required' name='additional_inf' id='additional_inf'>{{ old('additional_inf', isset($project['additional_inf']) ? $project->additional_inf : null) }}</textarea>
        </div>
    </div> <!-- additional_inf -->
    <div class="form-service">
        <button class="button button_green form-service__submit" type="submit">Отправить</button>
        <a class="button button_gray form-service__cancel" href="/">Отмена</a>
    </div>
</form>
@endsection
