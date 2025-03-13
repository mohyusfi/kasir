<?php

namespace App\Providers;

use App\Services\ProductImpl\ProductServiceImpl;
use App\Services\ProductService;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class ProductServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register services.
     */
    public array $singletons = [
        ProductService::class => ProductServiceImpl::class,
    ];

    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }

    public function provides(): array
    {
        return [
            ProductService::class,
        ];
    }
}
