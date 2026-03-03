<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Expense\ExpenseController;
use App\Http\Controllers\Invitations\InvitationsController;
use App\Http\Controllers\ColocationController;
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



Route::middleware(['auth'])->group(function () {
    Route::get('/colocations', [ColocationController::class, 'index'])->name('colocations.index');
    Route::get('/colocations/create', [ColocationController::class, 'create'])->name('colocations.create');
    Route::post('/colocations', [ColocationController::class, 'store'])->name('colocations.store');
    Route::get('/colocations/{colocation}', [ColocationController::class, 'show'])->name('colocations.show');
    Route::delete('/colocations/{colocation}', [ColocationController::class, 'destroy'])->name('colocations.destroy');
    Route::patch('/colocations/{colocation}/cancel', [ColocationController::class, 'cancel'])->name('colocations.cancel');
    Route::get('/colocations/{colocation}/edit', [ColocationController::class, 'edit'])->name('colocations.edit');
    Route::put('/colocations/{colocation}', [ColocationController::class, 'update'])->name('colocations.update');
    Route::get('/colocations/{colocation}/invite', [InvitationsController::class, 'create'])->name('invitations.create');
    Route::post('/colocations/invite', [InvitationsController::class, 'store'])->name('invitations.store');
    Route::get('/invitations/accept/{token}', [InvitationsController::class, 'accept'])->name('invitations.accept'); 

    Route::get('/colocations/{colocation}/expenses/create', [ExpenseController::class, 'create'])->name('expenses.create');
    Route::post('/colocations/{colocation}/expenses', [ExpenseController::class, 'store'])->name('expenses.store');
    Route::post('/colocations/{colocation}/quit', [ColocationController::class, 'quit'])
        ->name('colocations.quit');
    
});



    Route::prefix('user')->name('user.')->group(function () {

    Route::get('/dashboard',[DashboardController::class,'index'])->name('dashboard');
});


require __DIR__.'/auth.php';
