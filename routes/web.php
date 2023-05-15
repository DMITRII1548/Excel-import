<?php

use App\Http\Controllers\DownloadsFileController;
use App\Http\Controllers\ExcelFileController;
use App\Http\Controllers\ProfileController;
use App\Models\ExcelFile;
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
        Route::get('/join', [ExcelFileController::class, 'join'])->name('files.join');
        Route::post('/merge', [ExcelFile::class, 'merge'])->name('files.merge');
        Route::get('/create', [ExcelFileController::class, 'create'])->name('files.create');
        Route::post('/', [ExcelFileController::class, 'store'])->name('files.store');
        Route::get('/{file}', [ExcelFileController::class, 'show'])->name('files.show');
        Route::get('/download/{file}', [ExcelFileController::class, 'download'])->name('files.download');
        Route::get('/{file}/edit/column', [ExcelFileController::class, 'addColumn'])->name('files.edit.add.column');
        Route::patch('/{file}/column', [ExcelFileController::class, 'pushColumn'])->name('files.update.add.column');
        Route::get('/{file}/edit/field', [ExcelFileController::class, 'editField'])->name('files.edit.field');
        Route::put('/update/{file}/field', [ExcelFileController::class, 'updateField'])->name('files.update.field');
    });
});

require __DIR__ . '/auth.php';
