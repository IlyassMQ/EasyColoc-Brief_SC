<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    
});
//Admins routes



Route::prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard',[AdminController::class,'index']);
    Route::post('/users/{user}/ban', [AdminController::class, 'ban'])
        ->name('users.ban');

    Route::post('/users/{user}/unban', [AdminController::class, 'unban'])
        ->name('users.unban');
});


use App\Http\Controllers\ColocationController;

Route::middleware(['auth'])->group(function () {
    Route::get('/colocations', [ColocationController::class, 'index'])->name('colocations.index');
    Route::get('/colocations/create', [ColocationController::class, 'create'])->name('colocations.create');
    Route::post('/colocations', [ColocationController::class, 'store'])->name('colocations.store');
    Route::get('/colocations/{colocation}', [ColocationController::class, 'show'])->name('colocations.show');
});


Route::prefix('user')->name('user.')->group(function () {

    Route::get('/dashboard',[DashboardController::class,'index'])->name('dashboard');
});


require __DIR__.'/auth.php';
