<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Response;
use Mollie\Api\Exceptions\ApiException;
use Mollie\Laravel\Facades\Mollie;

class PaymentsController extends Controller
{
    /**
     * Handle webhook request.
     *
     * @param Payment $payment
     * @return Response
     * @throws ApiException
     */
    public function webhook(Payment $payment): Response
    {
        $molliePayment = Mollie::api()->payments()->get($payment->mollie_id);

        $payment->status = $molliePayment->status;
        $payment->save();

        return response(null, 204);
    }
}
