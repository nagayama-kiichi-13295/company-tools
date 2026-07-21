@extends('layouts.app')

@section('title', 'ログイン')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endpush

@section('content')

<div class="auth-wrap">

    <div class="auth-title">ログイン</div>

    @if($errors->any())
        <p class="flash-error">{{ $errors->first() }}</p>
    @endif

    <form action="/login" method="post">
        @csrf

        <div class="auth-group">
            <label>メールアドレス</label>
            <input type="email" name="email" value="{{ old('email') }}">
        </div>

        <div class="auth-group">
            <label>パスワード</label>
            <input type="password" name="password">
        </div>

        <button type="submit" class="auth-button">ログイン</button>
    </form>

    <div class="auth-footer">
        アカウントをお持ちでない方は<br>
        <a href="{{ url('/register') }}">新規登録はこちら</a>
    </div>

</div>

@endsection