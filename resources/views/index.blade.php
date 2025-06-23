@php use Illuminate\Support\Facades\Auth; @endphp
@extends('layout')

@section('title', 'Главная')

@section('content')
    <h1>Добро пожаловать в электронный журнал {{Auth::user() ? Auth::user()->name : ''}}!</h1>
    <div class="cards">
        @if(count($advs))
            @foreach($advs as $adv)
                <div class="card">
                    <h2>{{$adv->title}}</h2>
                    <p>{{$adv->content}}</p>
                    <a href="tutors.php" class="button">Перейти к репетиторам</a>
                </div>
            @endforeach
        @else
            <h3>Тут пока ничего нет :(</h3>
        @endif

    </div>

@endsection
