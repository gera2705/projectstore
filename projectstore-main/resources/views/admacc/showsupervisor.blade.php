@extends('layouts.admacc-master')

@section('title','Редактирование руководителя')


@section('content')
    <div style="padding-left:20px">
{{--        <a style="font-family: 'Montserrat',sans-serif;border-width: 1px;margin-bottom: 15px;margin-top: -6px;font-weight:500" href="{{ url()->previous() }}" class="button">Вернуться</a>--}}
        <form method="POST" action="{{ route('admacc_supervisor_update',['supervisorId'=>$supervisor->id]) }}" class="supervisor-registration">
            @csrf
            @method('PUT')
            <div class="supervisor-registration__row">
                <label for="" class="supervisor-registration__label">ФИО</label>
                <div>
                    @error('s_fio')
                    <div class="error">{{ $message }}</div>
                    @enderror
                    <input required name="s_fio" type="text" class="supervisor-registration__input not_required" value="{{ old('s_fio', isset($supervisor['fio']) ? $supervisor->fio : null) }}">
                </div>
            </div>
            <div class="supervisor-registration__row">
                <label for="" class="supervisor-registration__label">Логин</label>
                <div>
                    @error('username')
                    <div class="error">{{ $message }}</div>
                    @enderror
                    <input required name="username" type="text" class="supervisor-registration__input not_required" value="{{ old('username', isset($supervisor['username']) ? $supervisor->username : null) }}">
                </div>
            </div>
            <div class="supervisor-registration__row">
                <label for="" class="supervisor-registration__label">Пароль</label>
                <div>
                    @error('s_password')
                    <div class="error">{{ $message }}</div>
                    @enderror
                    <input placeholder="Оставить пустым, если не изменяете" name="s_password" type="text" class="supervisor-registration__input not_required" value="{{ old('s_password') }}">
                </div>
            </div>
            <div class="supervisor-registration__row">
                <label for="" class="supervisor-registration__label">Почта</label>
                <div>
                    @error('s_email')
                    <div class="error">{{ $message }}</div>
                    @enderror
                    <input required name="s_email" type="email" class="supervisor-registration__input not_required" value="{{ old('s_email', isset($supervisor['email']) ? $supervisor->email : null) }}">
                </div>
            </div>
            <div class="supervisor-registration__row">
                <label for="" class="supervisor-registration__label">Должность</label>
                <div>
                    @error('position')
                    <div class="error">{{ $message }}</div>
                    @enderror
                    <input required name="position" type="text" class="supervisor-registration__input not_required" value="{{ old('position', isset($supervisor['position']) ? $supervisor->position : null) }}">
                </div>
            </div>
            <div style="margin-top:37px;" class="supervisor-registration__row">
                <div>
                    <button style="margin-left: 5px;padding: 5px 20px;" class="button button_blue" type="submit">Изменить</button>
                </div>
                <div>
                    <a style="margin-left: 30px;padding: 5px 20px;font-family: 'Montserrat',sans-serif;" href="{{ url()->previous() }}" class="button button_gray">Вернуться</a>
                </div>
            </div>
        </form>
    </div>
@endsection
