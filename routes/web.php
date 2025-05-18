<?php

use App\Http\Controllers\ProfileController;
use App\Http\Middleware\OnlyAdminMiddleware;
use App\Http\Middleware\OnlyGuestMiddleware;
use App\Livewire\ChartPerjualanPage;
use App\Livewire\ConfirmTransactionPage;
use App\Livewire\DashboardPage;
use App\Livewire\HistoryTransactionPage;
use App\Livewire\HomePage;
use App\Livewire\ProductsPage;
use App\Livewire\SalesDetailsPage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpKernel\Exception\HttpException;

Route::get('/', HomePage::class)
        ->middleware(["OnlyGuest"]);

Route::get('/sales-details/{month}', SalesDetailsPage::class)
    ->middleware(['auth', OnlyAdminMiddleware::class])
        ->name('SalesDetails');

Route::get('/dashboard', DashboardPage::class)
        ->middleware(['auth', 'verified'])
            ->name('dashboard');

Route::get('/products', ProductsPage::class)
        ->middleware(['auth', OnlyAdminMiddleware::class])
            ->name('products');

Route::get('chart-penjualan', ChartPerjualanPage::class)
        ->middleware(['auth', OnlyAdminMiddleware::class])
            ->name('charts');

Route::get('/confirm-transaction/{id}', ConfirmTransactionPage::class)
        ->middleware(['auth'])
            ->name('confirm.transaction');

Route::get('/history-transaction', HistoryTransactionPage::class)
            ->middleware(['auth'])
                ->name('history.transaction');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
