@php use Illuminate\Support\Facades\Auth; @endphp
@extends('layout')

@section('title', 'Главная')

@section('content')
    <div class="container mt-5">
        <a href="{{route('adminGroup', ['id' => $groupId])}}">Назад</a>
        <h2>Добавить ученика</h2>
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
        @if (Auth::user()->role_id == 4)
        <form action="{{route('adminStoreUserGroup', ['courseId' => $courseId, 'groupId' => $groupId])}}" method="POST">
            @csrf

            <div class="form-group">
                <label for="user_id">ID ученика</label>
                <input type="text" class="form-control" id="user_id" name="user_id" required>
            </div>

            <button type="submit" class="btn btn-primary">Добавить пользователя</button>
        </form>
        @endif

        <div style="display: flex; flex-direction: column">
            <h3>Группы</h3>
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Ученик</th>
                    @if (Auth::user()->role_id == 4)
                    <th>Действие</th>
                    @endif
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->user->surname }} {{ $user->user->name }}</td>
                        @if (Auth::user()->role_id == 4)
                        <td><a href="{{route('adminDestroyUserGroup', ['courseId' => $courseId, 'groupId' => $groupId, 'userId' => $user->user->id])}}">Удалить</a></td>
                        @endif
                    </tr>
                @endforeach
                </tbody>
            </table>
            @if (count($users) == 0)
                <p>Ученики отсутствуют</p>
            @endif
        </div>
    </div>
@endsection
