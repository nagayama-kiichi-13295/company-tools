<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class MyPageController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $listedProducts = $user->products()
            ->with('category')
            ->latest()
            ->get();
        
        $purchasedProducts = $user->purchasedProducts()
            ->with(['category', 'user'])
            ->latest()
            ->get();
        
        return view('mypage.index', compact('listedProducts', 'purchasedProducts'));
    }
}
