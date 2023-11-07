<?php

use App\Http\Controllers\PaymentsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('l5-swagger.default.api');
});

// PaymentsController
Route::post('payments/{payment}/webhook', [PaymentsController::class, 'webhook'])->name('payments.webhook');
