@extends('layouts.app')

@section('title', '商品出品')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/form.css') }}">
@endpush

@section('content')

<h2>商品出品</h2>

@if ($errors->any())
    <ul class="error-list">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form action="{{ route('products.store') }}" method="post" enctype="multipart/form-data" class="form-card">
    @csrf

    <div class="form-group">
        <label>商品名</label>
        <input type="text" name="name" value="{{ old('name') }}">
    </div>

    <div class="form-group">
        <label>商品説明</label>
        <textarea name="description" rows="5">{{ old('description') }}</textarea>
    </div>

    <div class="form-group">
        <label>価格</label>
        <input type="number" name="price" value="{{ old('price') }}">
        <div class="form-hint">無料で譲る場合は 0 を入力してください</div>
    </div>

    <div class="form-group">
        <label>カテゴリ</label>
        <select name="category_id">
            <option value="">選択してください</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}"
                    {{ old('category_id') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label>商品画像</label>
        <input type="file" name="image" accept="image/*">
        <div class="form-hint">2MBまでの画像ファイル</div>
    </div>

    <div class="form-actions">
        <button type="submit">出品する</button>
        <a href="{{ route('products.index') }}" class="cancel-link">キャンセル</a>
    </div>

</form>

@endsection