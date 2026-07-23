@extends('layouts.app')
@section('title', 'グループタグ管理')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/group-tags.css') }}">
@endpush

@section('content')

<h2>グループタグ管理</h2>

@if(session('success'))
    <p class="flash-success">{{ session('success') }}</p>
@endif

@if($errors->any())
    <ul class="error-list">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<div class="gt-section">
    <h3>タグを追加</h3>
    <form action="{{ route('admin.group-tags.store') }}" method="post" class="gt-form">
        @csrf
        <input type="text" name="name" placeholder="例: 営業部, 開発チーム" value="{{ old('name') }}">
        <button type="submit">追加</button>
    </form>

    @if($groupTags->isEmpty())
        <p>まだタグはありません。</p>
    @else
        <div class="gt-list">
            @foreach($groupTags as $tag)
                <div class="gt-item">
                    <span class="gt-item-name">{{ $tag->name }}</span>
                    <span class="gt-item-count">{{ $tag->users_count }}人</span>
                    <form action="{{ route('admin.group-tags.destroy', $tag) }}" method="post"
                          onsubmit="return confirm('このタグを削除しますか？');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="gt-del">×</button>
                    </form>
                </div>
            @endforeach
        </div>
    @endif
</div>

<div class="gt-section">
    <h3>社員にタグをつける</h3>
    <table>
        <tr>
            <th>社員名</th>
            <th>現在のタグ</th>
            <th></th>
        </tr>
        @foreach(\App\Models\User::orderBy('name')->with('groupTags')->get() as $member)
            <tr>
                <td>{{ $member->name }}</td>
                <td>
                    @forelse($member->groupTags as $tag)
                        <span class="note-tag">{{ $tag->name }}</span>
                    @empty
                        <span style="color: #9ca3af;">なし</span>
                    @endforelse
                </td>
                <td>
                    <a href="{{ route('admin.group-tags.assign', $member) }}" class="btn-edit">編集</a>
                </td>
            </tr>
        @endforeach
    </table>
</div>

@endsection