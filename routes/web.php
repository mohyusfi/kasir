<?php

use App\Http\Controllers\ProfileController;
use App\Http\Middleware\OnlyAdminMiddleware;
use App\Http\Middleware\OnlyGuestMiddleware;
use App\Livewire\ConfirmTransactionPage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpKernel\Exception\HttpException;

Route::get('/', function () {
    return view('welcome');
})->middleware(["OnlyGuest"]);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/products', function () {
    return view('product');
})->middleware(['auth', OnlyAdminMiddleware::class])->name('products');

Route::get('/confirm-transaction/{id}', ConfirmTransactionPage::class)
        ->middleware(['auth'])->name('confirm.transaction');

Route::get('/history-transaction', function () {
    return view('history-product');
})->middleware(['auth'])->name('history.transaction');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
