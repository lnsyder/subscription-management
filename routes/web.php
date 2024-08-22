<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return response()->json(Auth::user());
});

Route::prefix('user')->middleware(['auth'])->group(function () {
    Route::post('/{user}/subscription', [SubscriptionController::class, 'store']);
    Route::put('/{user}/subscription/{subscription}', [SubscriptionController::class, 'update']);
    Route::delete('/{user}/subscription/{subscription}', [SubscriptionController::class, 'destroy']);
    Route::post('/{user}/transaction', [TransactionController::class, 'store']);
    Route::get('/{user}', [UserController::class, 'show']);
});

require __DIR__ . '/auth.php';
