@extends('layout')

@section('title', 'Главная')

@section('content')

    <div class="container mt-5">
        <h2>Создать курс</h2>

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

        <form action="{{route('adminStoreCourse')}}" method="POST">
            @csrf

            <div class="form-group">
                <label for="name">Название</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>

            <div class="form-group">
                <label for="teacher_id">Преподаватель</label>
                <select class="form-control" id="teacher_id" name="teacher_id" required>
                    <option value="">Выберите препода</option>
                    @foreach ($teachers as $teacher)
                        <option value="{{ $teacher->id }}">{{ $teacher->surname }} {{ $teacher->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="organization_id">Филиал</label>
                <select class="form-control" id="organization_id" name="organization_id" required>
                    <option value="">Выберите филиал</option>
                    @foreach ($organizations as $organization)
                        <option value="{{ $organization->id }}">{{ $organization->address }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="subject_id">Предмет</label>
                <select class="form-control" id="subject_id" name="subject_id" required>
                    <option value="">Выберите предмет</option>
                    @foreach ($subjects as $subject)
                        <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                    @endforeach
                </select>
            </div>


            <div class="form-group">
                <label for="cost">Цена</label>
                <input type="number" class="form-control" id="cost" name="cost" required>
            </div>

            <button type="submit" class="btn btn-primary">Создать курс</button>
        </form>
    </div>

@endsection
