@extends('layouts.app')
@section('title', 'メモ作成')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/form.css') }}">
    <link rel="stylesheet" href="{{ asset('css/group-tags.css') }}">
@endpush

@section('content')

<h2>メモ作成</h2>

@if($errors->any())
    <ul class="error-list">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form action="{{ route('notes.store') }}" method="post" class="form-card">
    @csrf
    <div class="form-group">
        <label>タイトル</label>
        <input type="text" name="title" value="{{ old('title') }}">
    </div>

    <div class="form-group">
        <label>タグ</label>
        <input type="text" name="tags" value="{{ old('tags') }}">
        <div class="form-hint">カンマ区切りで入力(例: 仕事, アイデア, 買い物)</div>
    </div>

    <div class="form-group">
        <label>共有するグループ</label>
        @if($groupTags->isEmpty())
            <div class="form-hint">共有できるグループがありません(管理者がグループを作成します)</div>
        @else
            <div class="gt-checklist">
                @foreach($groupTags as $group)
                    <label class="gt-check">
                        <input type="checkbox" name="group_tags[]" value="{{ $group->id }}"
                            {{ in_array($group->id, old('group_tags', [])) ? 'checked' : '' }}>
                        {{ $group->name }}
                    </label>
                @endforeach
            </div>
            <div class="form-hint">チェックしたグループの人が閲覧できます</div>
        @endif
    </div>

    <div class="form-actions">
        <button type="submit">保存する</button>
        <a href="{{ route('notes.index') }}" class="cancel-link">キャンセル</a>
    </div>
</form>

@endsection