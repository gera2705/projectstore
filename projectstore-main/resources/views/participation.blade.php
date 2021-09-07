@extends('layouts.master')

@section('title','Форма отправки заявки')

@section('content')
    <ul class="nav-panel main-content__nav-panel col-md-6">
        <li class="nav-panel__item">
            <a class="nav-panel__link" href="/">Главная</a>
            <img class="nav-panel__nav-elem" src="/images/nav-elem.svg">
        </li>
        <li class="nav-panel__item">
            <a class="nav-panel__link" href="{{ route('showProject',['projectId'=>$project->id]) }}">Карточка проекта</a>
            <img class="nav-panel__nav-elem" src="/images/nav-elem.svg">
        </li>
        <li class="nav-panel__item">
            <a class="nav-panel__link" href="{{ route('participation',['projectId'=>$project->id]) }}">Подача заявки</a>
            <img class="nav-panel__nav-elem" src="/images/nav-elem.svg">
        </li>
    </ul>
</div>
<div class="row">
    <form style="position:relative;" class="participation-form col-md-6" action=" {{ route('storeCandidate',['projectId'=>$project->id]) }}" method="POST">
        @csrf
        <div class="participation-form__title">
            {{ $project->title }}
            @if($errors->any())
                <div class="participation-error">Проверьте<br>правильность<br>формы</div>
            @else
                <div class="participation-error participation-error_hide">Проверьте<br>правильность<br>формы</div>
            @endif

        </div>
        <p class='note'><img src="/images/participation-star.svg"> - поля, обязательные к заполнению</p>
        <div class="participation-form__row properties__item checkbox_1_wrap">
            <label for='personconfirm' class="participation-form__label"><span>Согласие на передачу, обработку и хранение персональных данных<img src='/images/participation-star.svg'></span></label>
            <div style="margin-top:20px;" class="participation-form__checkbox-field participation-form__input-field">
                @error('personconfirm')
                <div style="position: absolute;margin-left: 50px;margin-top: -11px;" class="error">{{ $message }}</div>
                @enderror
                <label>
                    <input class="participation-form__confirm-checkbox" type='checkbox' name='personconfirm' id='personconfirm' {{ old('personconfirm') == "on" ? 'checked' : '' }}>
                    <span class="checkbox_1 checkmark" style="position:relative;top:0;right:0;"></span>
                </label>
            </div>
        </div>
        <div class="participation-form__row properties__item">
            <label for='fio' class="participation-form__label"><span>Ваше имя<img src='/images/participation-star.svg'></span></label>
            <div>
                @error('fio')
                <div class="error">{{ $message }}</div>
                @enderror
                <input class='participation-form__input-field' type='text' name='fio' id='fio' value="{{ old('fio') }}">
            </div>
        </div>
        <div class="participation-form__row properties__item">
            <label for='email' class="participation-form__label"><span>Ваш адрес<br>электронной почты<img src='/images/participation-star.svg'></span></label>
            <div>
                @error('email')
                <div class="error">{{ $message }}</div>
                @enderror
                <input class='participation-form__input-field' type='email' name='email' id='email' value="{{ old('email') }}">
            </div>
        </div>
        <div class="participation-form__row properties__item">
            <label for='phone' class="participation-form__label"><span>Телефон<img src='/images/participation-star.svg'></span></label>
            <div>
                @error('phone')
                <div class="error">{{ $message }}</div>
                @enderror
                <input class='participation-form__input-field' type='text' name='phone' id='phone' value="{{ old('phone') }}">
            </div>
        </div>
        <div class="participation-form__row properties__item">
            <label for='competencies' class="participation-form__label"><span>Какую роль/роли<br> хотели бы занять?<img src='/images/participation-star.svg'></span></label>
            <div>
                @error('competencies')
                <div class="error">{{ $message }}</div>
                @enderror
                <input class='participation-form__input-field' type='text' name='competencies' id='competencies' value="{{ old('competencies') }}">
            </div>
        </div>
        <div class="participation-form__row properties__item">
            <label for='skill' class="participation-form__label"><span>Какими навыками Вы<br> обладаете, над чем<br> работали ранее<img src='/images/participation-star.svg'></span></label>
            <div>
                @error('skill')
                <div class="error">{{ $message }}</div>
                @enderror
                <textarea class='participation-form__input-field' name='skill' id='skill'>{{ old('skill') }}</textarea>
            </div>
        </div>
        <div class="participation-form__row properties__item">
            <label class="participation-form__label"><span>На каком курсе Вы<br> обучаетесь?<img src='/images/participation-star.svg'></span></label>
            <div class="fieldset participation-form__fieldset">
                @error('course')
                <div class="error">{{ $message }}</div>
                @enderror
                <p>Курс</p>
                <label>1<input name='course' type='radio' value='1' {{ old('course') == '1' ? 'checked' : '' }}></label>
                <label>2<input name='course' type='radio' value='2' {{ old('course') == '2' ? 'checked' : '' }}></label>
                <label>3<input name='course' type='radio' value='3' {{ old('course') == '3' ? 'checked' : '' }}></label>
                <label>4<input name='course' type='radio' value='4' {{ old('course') == '4' ? 'checked' : '' }}></label>
            </div>
        </div>
        <div class="participation-form__row properties__item">
            <label for="training_group" class="participation-form__label"><span>Ваша учебная группа<img src='/images/participation-star.svg'></span></label>
            <div>
                @error('training_group')
                <div class="error">{{ $message }}</div>
                @enderror
                <input class='participation-form__input-field' type='text' name='training_group' id='training_group' value="{{ old('training_group') }}">
            </div>
        </div>
        <div class="participation-form__row properties__item">
            <label class="participation-form__label">Опыт участия в проектах</label>
            <div>
                @error('experience')
                <div class="error">{{ $message }}</div>
                @enderror
                <textarea class='participation-form__input-field' name='experience' id='experience'>{{ old('experience') }}</textarea>
            </div>
        </div>
        <div class="participation-form__row properties__item">
            <button class="button button_green participation-form__submit button_flat button_hover_participate" type="submit">Отправить заявку</button>
            <div>
                <a href="{{ url()->previous() }}" class="participation-form__cancel button button_gray button_flat button_hover_lightgray">Отмена</a>
            </div>
        </div>
    </form>
@endsection
