@php use Illuminate\Support\Facades\Auth; @endphp
@extends('layout')

@section('title', 'Главная')

@section('content')
    <div class="container mt-5">
        <a href="{{route('adminGroup', ['id' => $groupId])}}">Назад</a>
        <h2>Занятия</h2>

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
        <form action="{{route('adminStoreLesson', ['courseId' => $courseId, 'groupId' => $groupId])}}" method="POST">
            @csrf
            <h3>Добавить занятие</h3>
            <div class="form-group">
                <label for="date">Дата занятия</label>
                <input type="datetime-local" class="form-control" id="date" name="date" required>
            </div>

            <button type="submit" class="btn btn-primary">Добавить занятие</button>
        </form>
        @endif

        <div style="display: flex; flex-direction: column">
            <h3>Группы</h3>
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Занятие</th>
                    <th>Задания</th>
                    <th>Посещаемость</th>
                    @if (Auth::user()->role_id == 4)
                    <th>Действие</th>
                    @endif
                </tr>
                </thead>
                <tbody>
                @foreach($lessons as $lesson)
                    <tr>
                        <td>{{ $lesson->date }}</td>
                        <td><a href="{{route('adminTasks', ['courseId' => $courseId, 'groupId' => $groupId, 'lessonId' => $lesson->id])}}">Задания</a></td>
                        <td><a href="{{route('adminDates', ['courseId' => $courseId, 'groupId' => $groupId, 'lessonId' => $lesson->id])}}">Посещаемость</a></td>
                        @if (Auth::user()->role_id == 4)
                        <td><a href="{{route('adminDestroyLesson', ['courseId' => $courseId, 'groupId' => $groupId, 'lessonId' => $lesson->id])}}">Удалить</a></td>
                        @endif
                    </tr>
                @endforeach
                </tbody>
            </table>
            @if (count($lessons) == 0)
                <p>Занятия отсутствуют</p>
            @endif
        </div>
    </div>
@endsection
