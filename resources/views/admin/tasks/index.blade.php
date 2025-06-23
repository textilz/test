@php use Illuminate\Support\Facades\Auth; @endphp
@extends('layout')

@section('title', 'Главная')

@section('content')
    <div class="container mt-5">
        <a href="{{route('adminGroupLessons', ['courseId' => $courseId, 'groupId' => $groupId])}}">Назад</a>
        <h2>Задания</h2>

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

        <form action="{{route('adminStoreTasks', ['courseId' => $courseId, 'groupId' => $groupId, 'lessonId' => $lessonId])}}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Задание</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>

            <div class="form-group">
                <label for="homework">
                    <input type="checkbox" class="form-check-input" id="homework" name="homework">
                    Домашнее задание
                </label>
            </div>

            <button type="submit" class="btn btn-primary">Добавить задание</button>
        </form>

        <div style="display: flex; flex-direction: column">
            <h3>Задания</h3>
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Название</th>
                    <th>Оценки</th>
                    <th>Удалить</th>
                </tr>
                </thead>
                <tbody>
                @foreach($tasks as $task)
                    <tr>
                        <td>{{ $task->name . ' ' . ($task->homework ? '(Домашнее задание)' : '') }}</td>
                        <td><a href="{{route('adminAssessment', ['courseId' => $courseId, 'groupId' => $groupId, 'lessonId' => $lessonId, 'taskId' => $task->id])}}">Оценки</a></td>
                        <td><a href="{{route('adminDestroyTasks', ['courseId' => $courseId, 'groupId' => $groupId, 'lessonId' => $lessonId, 'taskId' => $task->id])}}">Удалить</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            @if (count($tasks) == 0)
                <p>Задания отсутствуют</p>
            @endif
        </div>
    </div>
@endsection
