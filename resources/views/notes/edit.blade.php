@extends('layouts.app')
@section('title', 'メモ編集')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/form.css') }}">
@endpush

@section('content')

<h2>メモ編集</h2>

@if($errors->any())
    <ul class="error-list">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form action="{{ route('notes.update', $note) }}" method="post" class="form-card">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label>タイトル</label>
        <input type="text" name="title" value="{{ old('title', $note->title) }}">
    </div>

    <div class="form-group">
        <label>本文</label>
        <textarea name="body" rows="8">{{ old('body', $note->body) }}</textarea>
    </div>

    <div class="form-group">
        <label>タグ</label>
        <input type="text" name="tags" value="{{ old('tags', $tagText) }}">
        <div class="form-hint">カンマ区切りで入力(例: 仕事, アイデア, 買い物)</div>
    </div>

    <div class="form-group">
        <label>共有するグループ</label>
        @if($groupTags->isEmpty())
            <div class="form-hint">共有できるグループがありません</div>
        @else
            <div class="gt-checklist">
                @foreach($groupTags as $group)
                    <label class="gt-check">
                        <input type="checkbox" name="group_tags[]" value="{{ $group->id }}"
                            {{ in_array($group->id, old('group_tags', $sharedIds)) ? 'checked' : '' }}>
                        {{ $group->name }}
                    </label>
                @endforeach
            </div>
        @endif
    </div>

    <div class="form-actions">
        <button type="submit">更新する</button>
        <a href="{{ route('notes.show', $note) }}" class="cancel-link">キャンセル</a>
    </div>
</form>

@endsection