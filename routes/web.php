<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GuestbookEntryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicGuestbookController;
use App\Http\Controllers\WeddingEventController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Authenticated Bride/Groom/Admin Portal
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Wedding Event Management
    Route::resource('weddings', WeddingEventController::class);

    // Guestbook check-in confirmation & CSV export
    Route::post('/guestbook-entries/{entry}/toggle-confirm', [GuestbookEntryController::class, 'toggleConfirm'])->name('entries.toggle-confirm');
    Route::delete('/guestbook-entries/{entry}', [GuestbookEntryController::class, 'destroy'])->name('entries.destroy');
    Route::get('/weddings/{wedding}/export-csv', [GuestbookEntryController::class, 'exportCsv'])->name('weddings.export-csv');
});

require __DIR__.'/auth.php';

// Public Guest RSVP & Wishes Wall (at bottom for slug matching)
Route::get('/invite/{slug}', [PublicGuestbookController::class, 'show'])->name('wedding.public');
Route::post('/invite/{slug}/rsvp', [PublicGuestbookController::class, 'store'])->name('wedding.public.store');
