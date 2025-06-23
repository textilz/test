@php use Illuminate\Support\Facades\Auth; @endphp
@extends('layout')

@section('title', 'Главная')

@section('content')
    <div class="container mt-5">
        <a href="{{route('adminCourse')}}">Назад</a>
        <h2>Добавить группу</h2>

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
        <form action="{{route('adminStoreGroup')}}" method="POST">
            @csrf
            <input type="hidden" name="course_id" value="{{$courseId}}">

            <div class="form-group">
                <label for="number">Номер группы</label>
                <input type="text" class="form-control" id="number" name="number" required>
            </div>

            <button type="submit" class="btn btn-primary">Добавить группу</button>
        </form>
        @endif

        <div style="display: flex; flex-direction: column">
            <h3>Группы</h3>
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Группа</th>
                    <th>Ученики</th>
                    <th>Занятия</th>
                    @if (Auth::user()->role_id == 4)
                    <th>Удалить</th>
                    @endif
                </tr>
                </thead>
                <tbody>
                @foreach($groups as $group)
                    <tr>
                        <td>{{ $group->number }}</td>
                        <td><a href="{{route('adminGroupUsers', ['courseId' => $courseId, 'groupId' => $group->id])}}">Смотреть</a></td>
                        <td><a href="{{route('adminGroupLessons', ['courseId' => $courseId, 'groupId' => $group->id])}}">Смотреть</a></td>
                        @if (Auth::user()->role_id == 4)
                        <td><a href="{{route('adminDestroyGroup', ['id' => $group->id])}}">Удалить</a></td>
                        @endif
                    </tr>
                @endforeach
                </tbody>
            </table>
            @if (count($groups) == 0)
                <p>Группы отсутствуют</p>
            @endif
        </div>
    </div>
@endsection
