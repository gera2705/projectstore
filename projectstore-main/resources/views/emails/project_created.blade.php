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
<p style="margin:0;font-family:'Montserrat',sans-serif;color: #0A0836;text-align:center">Запрос на экспертизу проекта</p>
<div>Проект {{ $project->name }} был создан руководителем "{{ $supervisor->fio }}"</div>
<div>Проект ожидает экспертизы на <a href="http://projfair.tw1.ru">сайте</a></div>
<div>Данное письмо отправляется всем администраторам. Возможно, экспертизу проведет другой администратор</div>
</body>
</html>
