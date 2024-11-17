<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Service\ProductService;
use Illuminate\Contracts\Foundation\Application;

class ProductServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(ProductService::class, function (Application $app) {
            return new ProductService();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
