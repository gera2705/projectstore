@extends('layouts.admacc-master')

@section('title','Экспертиза заявок')

@section('content')
    <div style="padding-left:20px">
        @include('messages.success')
        @include('messages.error')
        <div style="position:relative">
            <div class="approval-form">
                <div class="cross"></div>
                <div class="approval-form__title">Форма одобрения</div>
                <div class="approval-form__id">ID проекта: <b>41</b></div>
                <a href="#" class="approval-form__approve">Одобрить</a>
                <form action="{{ route('rejectProject') }}" class="approval-form__rejection-form" method="POST">
                    @csrf
                    <div class="approval-form__rejection-form-title">Причина отклонения</div>
                    <input name="project_id" type="hidden" value="1">
                    <div>
                        <textarea name="error_message" cols="14" rows="3" required></textarea>
                    </div>
                    <button class="approval-form__rejection-form-submit approval-form__approve" type="submit">Отклонить</button>
                </form>
            </div>
        </div>
        <div class="col-md-7">
            @include('messages.error')
            @include('messages.success')
        </div>
    <div class="row">
        <ul class="expertise-titles col-md-7">
            <li style="margin-left:46px;" class="expertise-titles__item">ID</li>
            <li style="margin-left:49px;" class="expertise-titles__item">Руководитель</li>
            <li style="margin-left:118px;" class="expertise-titles__item">Название</li>
        </ul>
    </div>
    @foreach ($projects as $project)
        @include('layouts.open-project',compact('project'))
    @endforeach
    <div class="row">
        <div class="col-md-8">
            {{ $projects->appends($_GET)->links() }}
        </div>
    </div>
    <div class="row">
    </div>
@endsection
