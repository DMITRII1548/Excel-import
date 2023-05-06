<?php

use App\Http\Controllers\DownloadsFileController;
use App\Http\Controllers\ExcelFileController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('files')->group(function () {
        Route::get('/create', [ExcelFileController::class, 'create'])->name('files.create');
        Route::post('/', [ExcelFileController::class, 'store'])->name('files.store');
        Route::get('/{file}', [ExcelFileController::class, 'show'])->name('files.show');
    });

    Route::get('/download/{file}', [DownloadsFileController::class, 'download'])->name('download.file');
});

require __DIR__.'/auth.php';
