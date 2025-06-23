@extends('layout')

@section('title', 'Главная')

@section('content')

    <div class="container mt-5">
        <h2>Создать пользователя</h2>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{route('adminStoreUser')}}" method="POST">
            @csrf

            <div class="form-group">
                <label for="name">Имя</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>

            <div class="form-group">
                <label for="surname">Фамилия</label>
                <input type="text" class="form-control" id="surname" name="surname" required>
            </div>

            <div class="form-group">
                <label for="birthday">Дата рождения</label>
                <input type="date" class="form-control" id="birthday" name="birthday" required>
            </div>

            <div class="form-group">
                <label for="email">Почта</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="password">Пароль</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>

            <div class="form-group">
                <label for="role_id">Роль</label>
                <select class="form-control" id="role_id" name="role_id" required>
                    <option value="">Выберите роль</option>
                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Создать пользователя</button>
        </form>
    </div>

@endsection
