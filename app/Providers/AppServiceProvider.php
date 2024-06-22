<?php

namespace App\Providers;

use App\Models\Order;
use App\Models\User;
use App\Policies\OrderPolicy;
use Illuminate\Support\Facades\Gate;
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
        /*Gate::define('view-order', function (User $user, Order $order) {
            return $user->id === $order->user_id;
        });*/

       Gate::before(function (User $user, string $ability) {
            if ($user->isAdmin()) {
                return true;
            }
        });
    }
}
