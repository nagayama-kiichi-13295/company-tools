@extends('layouts.app')

@section('title', 'イベント')

@section('content')

<h2>イベント</h2>

@if(session('success'))
    <p style="color: green;">{{ session('success') }}</p>
@endif

@can('create', App\Models\Event::class)
    <p>
        <a href="{{ route('events.create') }}">イベントを作成する</a>
    </p>
@endcan

@if($events->isEmpty())
    <p>イベントはありません。</p>
@else
    <table border="1" cellpadding="10">
        <tr>
            <th>タイトル</th>
            <th>開催日時</th>
            <th>参加人数</th>
        </tr>
        @foreach($events as $event)
            <tr>
                <td>
                    <a href="{{ route('events.show', $event) }}">{{ $event->title }}</a>
                </td>
                <td>{{ $event->held_at->format('Y/m/d H:i') }}</td>
                <td>{{ $event->participants_count }} 人</td>
            </tr>
        @endforeach
    </table>
@endif

@endsection