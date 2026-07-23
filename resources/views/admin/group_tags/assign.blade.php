@extends('layouts.app')

@section('title', 'タグ付与')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/group-tags.css') }}">
@endpush

@section('content')

<h2>{{ $user->name }} さんのタグ</h2>

<form action="{{ route('admin.group-tags.update', $user) }}" method="post">
    @csrf
    @method('PUT')

    @if($groupTags->isEmpty())
        <p>先にグループタグを作成してください。</p>
    @else
        <div class="gt-checklist">
            @foreach($groupTags as $tag)
                <label class="gt-check">
                    <input type="checkbox" name="group_tags[]" value="{{ $tag->id }}"
                        {{ in_array($tag->id, $assignedIds) ? 'checked' : '' }}>
                    {{ $tag->name }}
                </label>
            @endforeach
        </div>

        <div class="form-actions" style="margin-top:20px;">
            <button type="submit">保存する</button>
            <a href="{{ route('admin.group-tags.index') }}" class="cancel-link">キャンセル</a>
        </div>
    @endif
</form>

@endsection