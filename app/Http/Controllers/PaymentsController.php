<?php

namespace App\Http\Controllers;

use App\Models\Enums\PaymentStatus;
use App\Models\Payment;
use Illuminate\Http\Response;
use Mollie\Laravel\Facades\Mollie;

class PaymentsController extends Controller
{
    public function webhook(Payment $payment): Response
    {
        $molliePayment = Mollie::api()->payments()->get($payment->mollie_id);

        $payment->status = PaymentStatus::from($molliePayment->status);
        $payment->save();

        return response(null, 204);
    }
}
