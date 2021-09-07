{{--@component('mail::message')--}}
{{--# Introduction--}}

{{--The body of your message.--}}

{{--@component('mail::button', ['url' => ''])--}}
{{--Button Text--}}
{{--@endcomponent--}}

{{--Thanks,<br>--}}
{{--{{ config('app.name') }}--}}
{{--@endcomponent--}}
<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>
<body style="background: #F6FAFB">
<p style="text-align:center;margin:0;margin-bottom:13px;font-size:18px;">Ярмарка проектов</p>
<div style="height:1px;background:black"></div>
<p style="margin:0;font-family:'Montserrat',sans-serif;color: #0A0836;text-align:center">Вам пришла заявка на участие</p>
<p style="font-family:'Montserrat',sans-serif;letter-spacing: -0.015em;color: #0A0836;">{{ $project->title }}</p>
<div class="candidate-card">
    <div class="candidate-card__name">Имя участника: {{ $candidate->fio }}</div>
    <div class="candidate-card__group">Курс: {{ $candidate->course }} Группа: {{ $candidate->training_group }}</div>
    <div class="candidate-card__phone">Телефон: {{ $candidate->phone }}</div>
    <div class="candidate-card__email">E-mail учаcтника: {{ $candidate->email }}</div>
    <div class="candidate-card__experience">Опыт участия в проектах: {{ $candidate->experience }}</div>
    <div class="candidate-card__competencies">Какую роль/роли хотели бы занять: {{ $candidate->competencies }}</div>
    <div class="candidate-card__skill">Навыки, над чем работали ранее: {{ $candidate->skill }} </div>
</div>
</body>
</html>
