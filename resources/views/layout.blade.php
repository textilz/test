<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{asset('assets/img/logo2.png')}}" type="image/x-icon">
    <title>Электронный журнал | @yield('title')</title>
    <link rel="stylesheet" href="{{ asset('assets/css/global.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<header style="display: flex">
    <div class="logo">
        <img src="{{asset('assets/img/logo2.png')}}" alt="Логотип" />
        <span>Электронный журнал</span>
    </div>
    <div class="login-button">
        <span class="login-button-span">{{Auth::user() ? Auth::user()->name . ' ' . Auth::user()->surname . ' | ID:' . Auth::user()->id : ''}}</span>
        @if(Auth::user())
            <a href="{{route('logout')}}">Выйти</a>
        @else
            <a href="{{route('loginWeb')}}">Войти</a>
        @endif
    </div>
</header>

<nav>
    <ul>
        <li><a href="{{route('index')}}">Главная</a></li>
{{--        <li><a href="schedule.php">Расписание</a></li>--}}
        <li><a href="{{route('schedule')}}">Дневник</a></li>
        @if(Auth::check() && (Auth::user()->role_id == 3 || Auth::user()->role_id == 4))
        <li><a href="{{route('adminCourse')}}">Курсы</a></li>
        @endif

        @if(Auth::check() && Auth::user()->role_id == 4)
        <li><a href="{{route('adminUser')}}">Пользователи</a></li>
        @endif
    </ul>
</nav>

<main>
    @yield('content')
</main>

{{--<footer>--}}
{{--    <p>&copy; 2023 Электронный журнал. Все права защищены.</p>--}}
{{--</footer>--}}

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
