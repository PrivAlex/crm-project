<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\DealController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Dashboard от Breeze
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// CRM роуты (только для авторизованных)
Route::middleware(['auth'])->group(function () {

    // Clients
    Route::resource('clients', ClientController::class);

    // Deals
    Route::resource('deals', DealController::class);

    // Activities (только create/store/show - внутри сделки)
    Route::resource('activities', ActivityController::class)
        ->only(['create', 'store', 'show', 'destroy']);

    // Tasks
    Route::resource('tasks', TaskController::class);
});

require __DIR__.'/auth.php';
