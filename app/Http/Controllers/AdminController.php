<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Category;
use App\Models\Event;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard()
    {
        // 管理者以外は入れない
        abort_unless(Auth::user()->is_admin, 403);

        // 各種件数
        $userCount          = User::count();
        $productCount       = Product::count();
        $announcementCount  = Announcement::count();
        $eventCount         = Event::count();

        // 取引状態ごとの件数 (例: ['available' => 3, 'trading' => 1])
        $statusCounts = Product::selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        // カテゴリ別の出品数
        $categories = Category::withCount('products')
            ->orderBy('id')
            ->get();

        // バーグラフ用: 最大件数(0除算を避けるための最低1)
        $maxCategoryCount = max($categories->max('products_count') ?? 0, 1);
        
        // 最近の出品5件
        $recentProducts = Product::with('user')
            ->latest()
            ->take(5)
            ->get();
        
        return view('admin.dashboard', compact(
            'userCount',
            'productCount',
            'announcementCount',
            'eventCount',
            'statusCounts',
            'categories',
            'maxCategoryCount',
            'recentProducts',
        ));
    }
}
