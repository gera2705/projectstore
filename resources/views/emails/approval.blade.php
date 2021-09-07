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
@if ($project->error_message)
    <p style="margin:0;font-family:'Montserrat',sans-serif;color: #0A0836;text-align:center">Ваш проект "{{ $project->title }}" <span style="color:#E9430F">не прошел проверку</span></p>
@else
    <p style="margin:0;font-family:'Montserrat',sans-serif;color: #0A0836;text-align:center">Ваш проект "{{ $project->title }}" <span style="color:green">одобрен</span> и добавлен в общую ленту</p>
@endif
@if ($project->error_message)
    <p>Причина отказа:<span style="color:#051439;"> {{ $project->error_message }}</span></p>
    <p>Для исправления замечаний нужно перейти в "Мой кабинет", нажать на "Отрицательная экспертиза", а затем отредактировать некоторые данные</p>
@endif
<div style="font-family:'Montserrat',sans-serif;letter-spacing: -0.015em;color: #0A0836;">Название проекта: {{ $project->title }}</div>
<div class="candidate-card">
    <div>Цель проекта: {{ $project->goal }}</div>
    <div>Идея проекта: {{ $project->idea }}</div>
    <div>Требования к участникам: {{ $project->requirements }}</div>
    <div>Ожидаемый резульатат: {{ $project->expected_result }}</div>
    <div>Тип проекта: {{ $project->type_name }}</div>
    <div>Сколько человек требуется: {{ $project->places }}</div>
    <div>Теги проекта: <?php
        $tagsCount = $project->tags->count();
        $i = 0;
        for($i = 0;$i<$tagsCount;$i++) {
            if ($i != $tagsCount-1)
                echo $project->tags[$i]->tag . ", ";
            else
                echo $project->tags[$i]->tag;
        }
        ?>
    </div>
    @if(!empty($project->additional_inf))
        <div>Дополнительная информация: {{ $project->additional_inf }}</div>
    @endif
    <div>Планируемые сроки реализации: {{ date('j.m.y', strtotime($project->date_start)) }} – {{ date('j.m.y', strtotime($project->date_end)) }}</div>
</div>
</body>
</html>
