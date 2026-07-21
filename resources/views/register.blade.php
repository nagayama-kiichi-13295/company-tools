@extends('layouts.app')

@section('title', '新規登録')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endpush

@section('content')

<div class="auth-wrap">

    <div class="auth-title">新規登録</div>

    @if($errors->any())
        <ul class="error-list">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="{{ route('register') }}" method="post">
        @csrf

        <div class="auth-group">
            <label for="name">名前</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}">
        </div>

        <div class="auth-group">
            <label for="email">メールアドレス</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}">
        </div>

        <div class="auth-group">
            <label for="password">パスワード</label>
            <input type="password" id="password" name="password" required>
        </div>

        <div class="auth-group">
            <label for="password_confirmation">パスワード確認</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required>
        </div>

        <button type="submit" class="auth-button">登録する</button>
    </form>

    <div class="auth-footer">
        すでにアカウントをお持ちの方は<br>
        <a href="{{ route('login') }}">ログインはこちら</a>
    </div>

</div>

@endsection