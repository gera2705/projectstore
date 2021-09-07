<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>@yield('title')</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="/style/styles.css">
</head>
<body>
<header>
    <div class="container">
        <div class="row">
            <div class="header__left col-md-8">
                <a class="main-link" href="/"><img src="/images/new_logo.svg" class="logo @if(!Route::is('index')) logo_filter @endif"></a>
                @if (Auth::user())
                    <nav>
                        <ul class="nav">
                            <li class="nav__item">
                                <a @if(!Route::is('index')) style="color: #505666;" @endif href="{{ route('index' )}}" class="nav__link">Главная</a>
                            </li>

                            <li class="nav__item">
                                @if (Auth::user()->role === 'supervisor')
                                    <a @if(!Route::is('index')) style="color: #505666;" @endif href="{{ route('personalcab') }}" class="nav__link">Мой кабинет</a>
                                @else
                                    <a @if(!Route::is('index')) style="color: #505666;" @endif href="{{ route('expertise') }}" class="nav__link">Экспертиза заявок</a>
                                @endif
                            </li>

                        </ul>
                    </nav>
                @endif
            </div>
            <div class="header__right col-md-4">
                @if (Auth::user())
                    <div class="header__name">
                        {{ Auth::user()->fio }}
                    </div>
                    <div class="header__logo">
                        @if (Auth::user()->role === 'supervisor')
                            <img class="header__logo-icon" src="/images/teacherIcon.svg">
                        @else
                            <img class="header__logo-icon" src="/images/adminIcon.svg">
                        @endif
                        <div class="header__position">{{Auth::user()->position}}</div>
                    </div>
                    <img class="header__triangle" src="/images/triangle.svg">
                    <div style="min-width:100px;" class="profile-window"> <!-- profile-window -->
{{--                        <div class="profile-window__id">Ваш ID &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ Auth::user()->id }}</div>--}}
                        <ul class="profile-window__list">
                            <li class="profile-window__list-item">
                                @if (Auth::user()->role === 'admin')
                                    @if(Cookie::has('offDesign'))
                                        <a href="{{ route('toggleDesign') }}" class="profile-window__list-link">
                                            дизайн [<b style="color:#E86F2A;">OFF</b>]
                                        </a>
                                    @else
                                        <a href="{{ route('toggleDesign') }}" class="profile-window__list-link">
                                            дизайн [<b style="color:#30B700;">ON</b>]
                                        </a>
                                    @endif
                                    <a href="{{ route('admacc_projects') }}" class="profile-window__list-link">
                                        ЛК
                                    </a>
                                @endif
                                <a href="/logout" class="profile-window__list-link">
                                    Выйти
                                </a>
                            </li>
                        </ul>
                    </div>  <!-- profile-window -->

                @else
                    <img class="header__auth-img" src="/images/auth.svg" class="IRNITU-logo">
                    <div class="auth auth-restore">
                        <div class="auth__title">Восстановление данных</div>
                        <form method="POST" action="{{ route('resetLinkEmail') }}">
                            @csrf
                            <div class="cross"></div>
                            <p>Введите e-mail</p>
                            <input name='email' type="email">
                            <button style="margin-left:0;letter-spacing:0;" class="auth__submit button" type="submit">Восстановить</button>
                        </form>
                    </div>
                    <div class="auth"> <!-- Authorization window -->
                        <div class="auth__title">Авторизация</div>
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="cross"></div>
                            <p>Логин</p>
                            <div>
                                <input name='username' type="text">
                            </div>
                            <p>Пароль</p>
                            <div>
                                <input style="font-weight: bold;font-size: 19px;letter-spacing: 1.3px;line-height:23px;" name='password' cc-number type="password">
                            </div>
                            <a class="auth__forget-link" href="#">Забыли<br> данные?</a>
                            <button class="auth__submit button" type="submit">Войти</button>
                        </form>
                    </div>  <!-- Authorization window -->
                @endif
            </div>
        </div>
    </div>
</header>
{{--@if (!((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" == route('personalcab')))--}}

@yield('banner')
{{--@endif--}}
@yield('additional-block')
<div @if(Route::is('index') || Route::is('editProject') || Route::is('createProject')) style="padding-top: 13px;" @endif class="main-content">
    <div class="container">
        <div class="row">
            @yield('content')
        </div> <!-- row -->
    </div> <!-- container -->
</div>
<div class='footer'>
{{--    <div class="arrow"></div>--}}
    <div id="footer-container" class="container"></div>
    <div class='container'>
        <div class="row">
            <div class="footer__item col-md-4">
                <p>Федеральное Государственное Бюджетное Образовательное Учреждение высшего образования</p>
                <p class='footer__logo-wrap'><img style="height:56px;" class='footer__logo' src="/images/logo_footer.png"></p>
                <p id="IRNITU_footer">"Иркутский Национальный Исследовательский Технический Университет"</p>
            </div>
            <div class="footer__item col-md-3">
                <p>Контакты администратора:</p>
                <br>
                <p>Телефон: +7 (3952) 999-999</p>
                <p>E-mail: admin@admin.ru</p>
            </div>
            <div class="footer__item col-md-4">
                <p>Контакты организации</p>
                <br>
                <p>664074, г. Иркутск ул. Лермонтова 83</p>
                <p>Телефон: +7 (3952) 405-000</p>
                <p>Факс: +7 (3952) 405-100</p>
                <p>Справочная: +7 (3952) 405-009</p>
                <p>E-mail: info@istu.edu</p>
            </div>
        </div> <!-- row -->
    </div> <!-- container -->
</div> <!-- footer -->
<script type="text/javascript" src="/js/main.js"></script>
</body>
</html>
