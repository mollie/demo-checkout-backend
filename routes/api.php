<?php

use App\Http\Controllers\Api\MethodsController;
use App\Http\Controllers\Api\PaymentsController;
use Illuminate\Support\Facades\Route;

// PaymentMethodsController
Route::apiResource('methods', MethodsController::class)->only([
    'index',
]);

Route::middleware('device')->group(function () {
    // PaymentsController
    Route::apiResource('payments', PaymentsController::class)->only([
        'index', 'store', 'show',
    ]);
});
