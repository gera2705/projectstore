<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="/style/styles.css">
</head>
<body>
<div class="admin-header">
    <div class="container">
        <div class="row">
            <div style="text-align:center;" class="col-md-2 header__left">
                <a style="display:inline-block" href="{{ route('admacc_projects') }}">
                    <img class="logo admin-header__logo" src="/images/logo.svg" alt="">
                </a>
            </div>
            <div class="col-md-10 header__right">
                <div class="header__item writing"><b style="font-family: 'Montserrat',sans-serif;font-weight: 500;">{{ Auth::user()->fio }}</b><br>администратор</div>
                <img style="-webkit-user-select: none;-moz-user-select: none;-ms-user-select: none;user-select: none;" class="header__item" src="/images/adminIcon.svg" alt="">
                <img class="header__item header__triangle" src="/images/triangle.svg" alt="">


                <div style="margin-top:5px;" class="profile-window"> <!-- profile-window -->
{{--                    <div class="profile-window__id">Ваш ID &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ Auth::user()->id }}</div>--}}
                    <ul class="profile-window__list">
                        <li class="profile-window__list-item">
                            <a href="{{ route('index') }}" class="profile-window__list-link">Вернуться</a>
                        </li>
                        <li class="profile-window__list-item">
                            <a href="/logout" class="profile-window__list-link">
                                Выйти
                            </a>
                        </li>

                    </ul>
                </div>  <!-- profile-window -->


            </div> <!-- header-right -->
        </div> <!-- row -->
    </div> <!-- container -->
</div> <!-- admin-header -->
<div class="main-content-admin">
    <div class="container">
        <div class="row">
            @include('layouts.sidebar-admacc')
            <img class="admin-line" src="/images/admin-line.svg">
            <div class="col-md-9 main-admin">
                @yield('content')
            </div>
        </div> <!-- row -->
    </div> <!-- container -->
</div> <!-- main-content-admin -->
{{--<div class="footer-admin">--}}

{{--</div>--}}
<script type="text/javascript" src="/js/main.js"></script>

</body>
</html>
