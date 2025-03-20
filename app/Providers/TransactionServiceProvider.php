<?php

namespace App\Providers;

use App\Services\ProductImpl\TransactionServiceImpl;
use App\Services\TransactionService;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class TransactionServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register services.
     */
    public array $singletons = [
        TransactionService::class => TransactionServiceImpl::class,
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
        return [TransactionService::class];
    }
}
