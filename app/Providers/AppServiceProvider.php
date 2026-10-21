<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


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
        Schema::defaultStringLength(191);
        View::composer('layouts.site-layout', function ($view) {
            $userId = Auth::id();

            // Wishlist: unique favorite products
            $wishlistCount = 0;

            if ($userId) {
                $wishlistCount = DB::table('favorites')
                    ->where('user_id', $userId)
                    ->distinct()
                    ->count('product_id');
            }

            // Cart: logged-in user's database cart
            $dbCartCount = 0;

            if ($userId) {
                $dbCartCount = (int) DB::table('cart')
                    ->where('user_id', $userId)
                    ->sum('quantity');
            }

            // Guest cart: session cart
            $sessionCart = session('food_cart', []);
            $guestCartCount = 0;

            if (!$userId && is_array($sessionCart)) {
                foreach ($sessionCart as $item) {
                    $guestCartCount += (int) (
                        is_array($item) ? ($item['quantity'] ?? 1) : 1
                    );
                }
            }

            $view->with('headerWishlistCount', $wishlistCount);
            $view->with(
                'headerCartCount',
                $userId ? $dbCartCount : $guestCartCount
            );
        });
    }
}

