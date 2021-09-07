@extends('layouts.master')

@section('title','Зачем участвовать')

@section('content')
    <ul style="margin-top:-7px;" class="nav-panel main-content__nav-panel col-md-6">
        <li class="nav-panel__item">
            <a class="nav-panel__link" href="/">Главная</a>
            <img class="nav-panel__nav-elem" src="/images/nav-elem.svg">
        </li>
        <li class="nav-panel__item">
            <a class="nav-panel__link" href="{{ route('why-answer') }}">Зачем участвовать в проектах?</a>
        </li>
    </ul>
@endsection
