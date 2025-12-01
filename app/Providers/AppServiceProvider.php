<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
        // View Composer for Feed Sidebar
        \Illuminate\Support\Facades\View::composer('components.feed-sidebar', function ($view) {
            $suggestedUsers = [];
            if (\Illuminate\Support\Facades\Auth::check()) {
                $userId = \Illuminate\Support\Facades\Auth::id();
                // Cache suggestions for 5 minutes to reduce DB load
                $suggestedUsers = \Illuminate\Support\Facades\Cache::remember('suggested_users_' . $userId, 300, function () use ($userId) {
                    return \App\Models\User::where('id_usuario', '!=', $userId)
                        ->inRandomOrder()
                        ->take(3)
                        ->get();
                });
            }
            $view->with('suggestedUsers', $suggestedUsers);
        });
    }
}
