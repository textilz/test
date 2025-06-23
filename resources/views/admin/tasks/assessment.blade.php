@php use Illuminate\Support\Facades\Auth; @endphp
@extends('layout')

@section('title', 'Главная')

@section('content')
    <div class="container mt-5">
        <h2>Оценки</h2>

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

        <form action="{{route('adminStoreAssessment', ['courseId' => $courseId, 'groupId' => $groupId, 'lessonId' => $lessonId, 'taskId' => $taskId])}}" method="POST">
            @csrf
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Ученик</th>
                    <th>Оценка</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user['name'] }}</td>
                        <td><input name="user-{{ $user['user_id'] }}" type="text" value="{{ $user['assessment'] }}"></td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <button type="submit" class="btn btn-primary">Готово</button>
        </form>
    </div>
@endsection
