@php use Illuminate\Support\Facades\Auth; @endphp
@extends('layout')

@section('title', 'Главная')

@section('content')
    <div class="container mt-5">
        <h2>Список пользователей</h2>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <a href="{{route('adminStoreUserWeb')}}" class="btn btn-success">Создать пользователя</a>

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>Имя</th>
                <th>Фамилия</th>
                <th>Дата рождения</th>
                <th>Email</th>
                <th>Роль</th>
                <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->surname }}</td>
                    <td>{{ $user->birthday ? $user->birthday : 'Не указана' }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role->name ?? 'Не указана' }}</td>
                    <td>Удалить</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
