<?php

use App\Http\Controllers\Admin\DishController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    //User - da completare!
    Route::get('user', [DashboardController::class, 'index'])->name('user');

    Route::resource('dishes', DishController::class)->parameters(['dishes' => 'dish:slug']);

    //amdin/recycle - show trashed dishes
    Route::get('recycle', [DishController::class, 'recycle'])->name('dishes.recycle');

    //restore trashed dishes
    Route::get('dishes/restore/{id}', [DishController::class, 'restore'])->name('dishes.restore');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
