

@extends('layout')

@section('title', 'Войти')

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{route('login')}}" method="POST">
        @csrf
        <h2>Авторизация</h2>
        <label for="email">Электронная почта</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Пароль</label>
        <input type="password" id="password" name="password" required>
        <button type="submit">Войти</button>
    </form>


@endsection
