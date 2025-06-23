@php use Illuminate\Support\Facades\Auth; @endphp
@extends('layout')

@section('title', 'Главная')

@section('content')
    <table class="journal-table">
        <tbody class="journal-body">
        @foreach($data as $item)
            <tr>
                <td class="journal-day" style="width: 30%">
                    <div style="font-size: 20px">{{$item['weekday']}}</div>
                    <div>{{$item['date_formatted']}}</div>
                </td>
                <td style="display: flex; flex-direction: column; font-size: 20px; gap: 20px">
                    @if(count($item['lessons']) != 0)
                    @foreach($item['lessons'] as $lesson)
                        <div style="display: flex; flex-direction: row; gap: 20px">
                            <div style="display: flex; flex-direction: row">
                                {{$lesson['subject']}} {{$lesson['time']}} - {{$lesson['time_end']}}
                            </div>
                            <div style="display: flex; flex-direction: column; gap: 5px">
                                @foreach($lesson['tasks'] as $task)
                                    <div>{{$task['name']}} (Оценка: {{$task['assessment']}})</div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                    @else
                        <p>Занятий нет</p>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>


    <div style="display: flex; gap: 10px; justify-content:center;">
        <a class="btn btn-primary" href="{{ route('schedule', ['week' => $week_offset - 1]) }}">← Предыдущая неделя</a>
        <a class="btn btn-primary" href="{{ route('schedule', ['week' => $week_offset + 1]) }}">Следующая неделя →</a>
    </div>


@endsection
