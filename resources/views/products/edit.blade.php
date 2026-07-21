@extends('layouts.app')

@section('title', '商品編集')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/form.css') }}">
@endpush

@section('content')

<h2>商品編集</h2>

@if ($errors->any())
    <ul class="error-list">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form action="{{ route('products.update', $product) }}" method="post" enctype="multipart/form-data" class="form-card">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label>商品名</label>
        <input type="text" name="name" value="{{ old('name', $product->name) }}">
    </div>

    <div class="form-group">
        <label>商品説明</label>
        <textarea name="description" rows="5">{{ old('description', $product->description) }}</textarea>
    </div>

    <div class="form-group">
        <label>価格</label>
        <input type="number" name="price" value="{{ old('price', $product->price) }}">
    </div>

    <div class="form-group">
        <label>カテゴリ</label>
        <select name="category_id">
            <option value="">選択してください</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}"
                    {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label>商品画像</label>
        @if($product->image_path)
            <div class="current-image">
                <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}">
            </div>
        @endif
        <input type="file" name="image" accept="image/*">
        <div class="form-hint">変更しない場合は選択不要です</div>
    </div>

    <div class="form-actions">
        <button type="submit">更新する</button>
        <a href="{{ route('products.show', $product) }}" class="cancel-link">キャンセル</a>
    </div>

</form>

@endsection