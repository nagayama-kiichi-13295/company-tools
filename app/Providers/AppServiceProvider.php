<?php

namespace App\Providers;

use App\Models\DirectMessage;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // 前頁共有でサイドバーに未読件数を渡す
        View::composer('layouts.app', function ($view) {
            $unreadTotal = 0;

            if (Auth::check()) {
                $unreadTotal = DirectMessage::where('receiver_id', Auth::id())
                    ->whereNull('read_at')
                    ->count();
            }

            $view->with('unreadTotal', $unreadTotal);
        });
    }
}
