<?php

use App\Http\Controllers\MovieController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\UserController;



Route::get('/', [UserController::class, 'landing'])->name('landing');
Route::get('/toko', [UserController::class, 'toko'])->name('toko');
Route::post('/produk/add', [ProdukController::class, 'addToWishlist'])->name('produk.add');
 

// Route for the signup form
Route::get('/signup', [UserController::class, 'showSignupForm'])->name('signup.create');
Route::post('/signup', [UserController::class, 'signup'])->name('signup.store');

// Route for the login form
Route::get('/login', [UserController::class, 'showLoginForm'])->name('login');
Route::post('/login', [UserController::class, 'login'])->name('login.post');

// Optional: Route for logging out
Route::post('/logout', [UserController::class, 'logout'])->name('logout');

// Profile Routes

Route::put('/profile', [UserController::class, 'updateProfile'])->name('profile.update');

// Routes that require authentication
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [UserController::class, 'showProfile'])->name('profile.show');
    Route::get('/search', [UserController::class, 'showSearch'])->name('search');
    Route::get("/dashboard", [ProdukController::class, 'index'])->name('index.index');
    Route::get('/produk/create', [ProdukController::class, 'create'])->name('index.create');
    Route::post('/produk/store', [ProdukController::class, 'store'])->name('index.store');
    Route::get('/produk/edit/{id}', [ProdukController::class, 'edit'])->name('index.edit');
    Route::put('/produk/update/{id}', [ProdukController::class, 'update'])->name('index.update');
    Route::delete('/produk/delete/{id}', [ProdukController::class, 'destroy'])->name('index.destroy');
});


?>