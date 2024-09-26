<?php

namespace App\Providers;

use Illuminate\Support\Facades\Response;
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
        Response::macro('success', function ($data, $status_code = 200) {
            return response()->json([
                'success' => true,
                'data' => $data
            ], $status_code);
        });

        Response::macro('error', function ($error, $status_code) {
            return response()->json([
                'success' => false,
                'error' => $error
            ], $status_code);
        });
    }
}
