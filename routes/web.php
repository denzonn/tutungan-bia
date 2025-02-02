<?php

use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\CategoryArticleController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DocumentController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserViewController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [UserViewController::class, 'index'])->name('home');
Route::get('/profil', [UserViewController::class, 'profil'])->name('profil');
Route::get('/berita', [UserViewController::class, 'berita'])->name('berita');
Route::get('/berita/{slug}', [UserViewController::class, 'detailBerita'])->name('detail-berita');
Route::get('/artikel', [UserViewController::class, 'artikel'])->name('artikel');
Route::get('/artikel/{slug}', [UserViewController::class, 'detailArtikel'])->name('detail-artikel');
Route::get('/dokumen', [UserViewController::class, 'dokument'])->name('dokument');


Route::prefix('admin')
    ->middleware(['auth'])
    ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('admin.dashboard')
            ->middleware('can:viewDashboard');

        Route::resource('berita', NewsController::class)
            ->middleware('can:viewBerita,editBerita');

        Route::resource('kategori-artikel', CategoryArticleController::class)
            ->middleware('role:SUPERADMIN');

        Route::resource('artikel', ArticleController::class)
            ->middleware('can:viewArtikel,editArtikel');

        Route::resource('user', UserController::class)
            ->middleware('role:SUPERADMIN');

        Route::resource('dokumen', DocumentController::class)
            ->middleware('role:SUPERADMIN');

        Route::get('profile', [ProfileController::class, 'index'])
            ->name('admin.profile')
            ->middleware('role:SUPERADMIN');

        Route::put('profile', [ProfileController::class, 'update'])
            ->name('admin.profile.update')
            ->middleware('role:SUPERADMIN');
    });


Auth::routes();
