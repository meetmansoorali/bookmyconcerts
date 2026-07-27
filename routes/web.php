<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConcertController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;

Route::get('/', [ConcertController::class, 'index'])->name('home');
Route::get('/concerts/{id}', [ConcertController::class, 'show'])->name('concerts.show');

Route::get('/dashboard', function () {
    return redirect()->route('home');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::post('/concerts/{id}/book', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/concerts/{id}/checkout', [BookingController::class, 'checkout'])->name('concerts.checkout');
    Route::post('/concerts/{id}/pay', [BookingController::class, 'processPayment'])->name('concerts.pay');
    Route::get('/my-tickets', [BookingController::class, 'index'])->name('my.tickets');
    Route::get('/my-tickets/{id}', [BookingController::class, 'showTicket'])->name('my.tickets.show');
    Route::delete('/my-tickets/{id}', [BookingController::class, 'destroy'])->name('my.tickets.destroy');
});
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::post('/admin/concerts', [AdminController::class, 'storeConcert'])->name('admin.concerts.store');
    Route::post('/admin/users/{id}/toggle', [AdminController::class, 'toggleAdmin'])->name('admin.users.toggle');
    Route::delete('/admin/concerts/{id}', [AdminController::class, 'destroyConcert'])->name('admin.concerts.destroy');
    Route::delete('/admin/bookings/{id}', [AdminController::class, 'destroyBooking'])->name('admin.bookings.destroy');
});

require __DIR__.'/auth.php';