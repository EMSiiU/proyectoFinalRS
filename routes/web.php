<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});



// Simple demo view routes for the static pages added from HTML -> Blade
Route::view('/feed', 'feed')->name('feed');
Route::view('/notifications', 'notifications')->name('notifications');
use App\Http\Controllers\MessageController;

// ...

Route::get('/messages/{id?}', [MessageController::class, 'index'])->name('messages')->middleware('auth');
Route::post('/messages', [MessageController::class, 'store'])->name('messages.store')->middleware('auth');
Route::view('/settings', 'settings')->name('settings');
Route::view('/chats', 'chats')->name('chats');
Route::view('/search', 'search')->name('search');
// profile is already used by auth/profile routes; expose a demo profile page under /myprofile
Route::view('/myprofile', 'profile')->name('myprofile');

Route::middleware('auth')->group(function () {
    // Profile setup after registration
    Route::get('/profile/setup', [ProfileController::class, 'setup'])->name('profile.setup');
    Route::post('/profile/setup', [ProfileController::class, 'storeSetup'])->name('profile.setup.store');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Follow system routes
    Route::post('/users/{user}/follow', [\App\Http\Controllers\FollowController::class, 'store'])->name('users.follow');
    Route::delete('/users/{user}/unfollow', [\App\Http\Controllers\FollowController::class, 'destroy'])->name('users.unfollow');
});

require __DIR__.'/auth.php';
