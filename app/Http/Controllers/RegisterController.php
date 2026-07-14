<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    // 登録画面
    public function index()
    {
        return view('register');
    }

    // 登録処理
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => ['required', 'max:255'],
            'email'    => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'confirmed', 'min:4'],
        ]);

        $user = User::create($validated);
        Auth::login($user);
        return redirect('/home');
    }
}