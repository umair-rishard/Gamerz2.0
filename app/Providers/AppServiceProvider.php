<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;

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
        // Define the 'api' rate limiter used by ThrottleRequests(':api')
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by(
                optional($request->user())?->id ?: $request->ip()
            );
        });
    }
}
