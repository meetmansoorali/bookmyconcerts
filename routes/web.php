<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ConcertController;
use App\Http\Controllers\BookingController;
use Illuminate\Support\Facades\Route;

// public routes
Route::get('/', [ConcertController::class, 'index'])->name('home');
Route::get('/concerts/{id}', [ConcertController::class, 'show'])->name('concerts.show');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::post('/concerts/{id}/book', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/my-tickets', [BookingController::class, 'index'])->name('my.tickets');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/concerts/{id}/checkout', [BookingController::class, 'checkout'])->name('concerts.checkout');
    Route::post('/concerts/{id}/pay', [BookingController::class, 'processPayment'])->name('concerts.pay');
    Route::get('/my-tickets', [BookingController::class, 'index'])->name('my.tickets');
});

require __DIR__.'/auth.php';
