@extends('layouts.app')
@section('title', 'お知らせ')
@section('content')

<h2>お知らせ</h2>

@if(session('success'))
    <p style="color: green;">{{ session('success') }}</p>
@endif

@can('create', App\Models\Announcement::class)
    <p>
        <a href="{{ route('announcements.create') }}">お知らせを投稿する</a>
    </p>
@endcan

@if($announcements->isEmpty())
    <p>お知らせはありません</p>
@else
    <table>
        <tr>
            <th>タイトル</th>
            <th>投稿者</th>
            <th>登校日</th>
        </tr>
        @foreach($announcements as $announcement)
            <tr>
                <td>
                    @if($announcement->is_pinned)
                        <strong>[重要]</strong>
                    @endif
                    <a href="{{ route('announcements.show', $announcement) }}">
                        {{ $announcement->title }}
                    </a>
                </td>
                <td>{{ $announcement->user->name }}</td>
                <td>{{ $announcement->created_at->format('Y/m/d') }}</td>
            </tr>
        @endforeach
    </table>
@endif

@endsection