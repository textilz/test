@php use Illuminate\Support\Facades\Auth; @endphp
@extends('layout')

@section('title', 'Главная')

@section('content')
    <div class="container mt-5">
        <h2>Список курсов</h2>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (Auth::user()->role_id == 4)
        <a href="{{route('adminStoreCourseWeb')}}" class="btn btn-success">Создать курс</a>
        @endif

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>Название</th>
                <th>Преподаватель</th>
                <th>Адрес</th>
                <th>Предмет</th>
                <th>Цена</th>
                <th>Группы</th>
                @if (Auth::user()->role_id == 4)
                <th>Удалить</th>
                @endif
            </tr>
            </thead>
            <tbody>
            @foreach ($courses as $course)
                <tr>
                    <td>{{ $course->id }}</td>
                    <td>{{ $course->name }}</td>
                    <td>{{ $course->teacher->surname }} {{ $course->teacher->name }}</td>
                    <td>{{ $course->organization->address }}</td>
                    <td>{{ $course->subject->name }}</td>
                    <td>{{ $course->cost}}</td>
                    <td><a href="{{route('adminGroup', ['id' => $course->id])}}">Смотреть</a></td>
                    @if (Auth::user()->role_id == 4)
                    <td><a href="{{route('adminDestroyCourse', ['id' => $course->id])}}">Удалить</a></td>
                    @endif
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
