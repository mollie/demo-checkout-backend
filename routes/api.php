<?php

// PaymentMethodsController
Route::resource('methods', 'MethodsController')->only(
    'index'
);

Route::middleware('device')->group(function () {
    // PaymentsController
    Route::resource('payments', 'PaymentsController')->only(
        'index', 'store', 'show'
    );
});
