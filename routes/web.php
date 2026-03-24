<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminProductController;

/*
|--------------------------------------------------------------------------
| PT. Mitra Abadi Metalindo — Web Routes
|--------------------------------------------------------------------------
*/

// ── PUBLIC ROUTES ─────────────────────────────────────────────────────────

Route::get('/', fn() => view('home'))->name('home');
Route::get('/product', [ProductController::class, 'index'])->name('product');
Route::get('/product/{slug}', [ProductController::class, 'show'])->name('product.show');
Route::get('/about-us', fn() => view('about'))->name('about-us');
Route::get('/contact-us', fn() => view('contact'))->name('contact-us');

// Redirect aliases
Route::redirect('/products', '/product', 301);
Route::redirect('/about',    '/about-us', 301);
Route::redirect('/contact',  '/contact-us', 301);
Route::redirect('/abaut-us', '/about-us', 301);
Route::redirect('/home',     '/', 301);

// ── ADMIN AUTH ────────────────────────────────────────────────────────────

Route::prefix('admin')->name('admin.')->group(function () {

    // Login (guest only)
    Route::middleware('guest')->group(function () {
        Route::get('/login',  [AdminController::class, 'loginForm'])->name('login');
        Route::post('/login', [AdminController::class, 'login'])->name('login.post');
    });

    // Logout
    Route::post('/logout', [AdminController::class, 'logout'])->name('logout');

    // ── PROTECTED ADMIN ROUTES ─────────────────────────────────────────
    Route::middleware('admin')->group(function () {

        // Dashboard
        Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');

        // Products CRUD
        Route::prefix('products')->name('products.')->group(function () {
            Route::get('/',              [AdminProductController::class, 'index'])->name('index');
            Route::get('/create',        [AdminProductController::class, 'create'])->name('create');
            Route::post('/',             [AdminProductController::class, 'store'])->name('store');
            Route::get('/{slug}/edit',   [AdminProductController::class, 'edit'])->name('edit');
            Route::put('/{id}',          [AdminProductController::class, 'update'])->name('update');
            Route::patch('/{id}/toggle', [AdminProductController::class, 'toggle'])->name('toggle');
            Route::delete('/{id}',       [AdminProductController::class, 'destroy'])->name('destroy');
        });

    });

});
Route::patch('admin/products/{product}/toggle-featured', [\App\Http\Controllers\Admin\AdminProductController::class, 'toggleFeatured'])->name('admin.products.toggle-featured');
