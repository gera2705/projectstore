@extends('layouts.master')

@section('title','Сброс пароля')


@section('content')
    <?php
    use App\User;
    $user = User::where('email',$email)->first();
    ?>

    <div class="reset-title col-md-offset-2 col-md-5">Здравствуйте,<br> {{ $user->fio }}</div>
</div> <!-- row -->
<div class="row">
    <form class="reset-form col-md-8" method="POST" action="{{ route('resetPassword') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <input type="hidden" name="email" value="{{ $email ?? old('email') }}">
        <div class="reset-form__row">
            <div class="reset-form__label">Ваш логин:</div>

            <div>{{ User::where('email',$email)->first()->username }}</div>
        </div>
        <div class="reset-form__row">
            <div class="reset-form__label">Введите новый пароль:</div>
            <input style="font-size:22px;" name="password" type="password" class="reset-form__input" required autocomplete="new-password">
        </div>
        <div class="reset-form__row">
            <div class="reset-form__label">Подтвердите пароль:</div>
            <div>
                @error('password')
                    <div class="error">{{ $message }}</div>
                @enderror
                <input style="font-size:22px;" name="password_confirmation" type="password" class="reset-form__input" required autocomplete="new-password">
            </div>
        </div>
        <div class="reset-form__row">
            <div class="reset-form__label"></div>
            <div style="text-align:center">
                <button style="margin-left: -52px;" class="reset-form__submit" type="submit">Сменить пароль</button>
            </div>
        </div>

    </form>
@endsection
