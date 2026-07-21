<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Event;
use App\models\Product;


class HomeController extends Controller
{
    public function index()
    {
        // 重要なお知らせを優先して3件
        $announcements = Announcement::with('user')
            ->orderByDesc('is_pinned')
            ->latest()
            ->take(3)
            ->get();

        // これから開催されるイベントを3件
        $events = Event::withCount('participants')
            ->where('held_at', '>=', now())
            ->orderBy('held_at')
            ->take(3)
            ->get();

        // 募集中の新着出品を4件
        $products = Product::with(['user', 'category'])
            ->where('status', 'available')
            ->latest()
            ->take(4)
            ->get();

        return view('home', compact('announcements', 'events', 'products'));
    }    
}
