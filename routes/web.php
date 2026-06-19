<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ClaimController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| GUEST ROUTES
| Hanya bisa diakses jika user BELUM login
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');
});

/*
|--------------------------------------------------------------------------
| AUTHENTICATED ROUTES
| Hanya bisa diakses jika user SUDAH login
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/cari-barang', [ItemController::class, 'index'])->name('items.index');
    Route::get('/laporkan/{type}', [ItemController::class, 'create'])->name('lapor');
    Route::post('/items', [ItemController::class, 'store'])->name('items.store');
    Route::get('/items/{item}', [ItemController::class, 'show'])->name('items.show');
    Route::get('/items/{item}/edit', [ItemController::class, 'edit'])->name('items.edit');
    Route::put('/items/{item}', [ItemController::class, 'update'])->name('items.update');
    Route::delete('/items/{item}', [ItemController::class, 'destroy'])->name('items.destroy');
    Route::post('/items/{item}/claim', [ItemController::class, 'submitClaim'])->name('items.claim');

    Route::get('/klaim-saya', [ClaimController::class, 'index'])->name('claims.index');
    Route::get('/klaim-saya/{claim}', [ClaimController::class, 'show'])->name('claims.show');
    Route::put('/klaim-saya/{claim}/bukti', [ClaimController::class, 'uploadBukti'])->name('claims.uploadBukti');

    Route::get('/notifikasi', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifikasi/{notification}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifikasi/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.readAll');
    Route::delete('/notifikasi/{notification}', [NotificationController::class, 'destroy'])->name('notifications.destroy');

    Route::get('/profil', function () {
        return view('user.detail-user', ['user' => auth()->user()]);
    })->name('profil');

    Route::middleware('admin')->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
        Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    });
});

/*
|--------------------------------------------------------------------------
| FALLBACK: Redirect ke login jika belum login
|--------------------------------------------------------------------------
*/
Route::fallback(function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});
