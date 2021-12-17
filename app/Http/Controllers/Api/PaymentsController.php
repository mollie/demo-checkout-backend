<?php

namespace App\Http\Controllers\Api;

use App\Http\Middleware\Device;
use App\Http\Requests\PaymentRequest;
use App\Http\Resources\PaymentResource;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Mollie\Api\Exceptions\ApiException;
use Mollie\Laravel\Facades\Mollie;

class PaymentsController extends Controller
{
    /**
     * List payments.
     *
     * @param Request $request
     * @return ResourceCollection
     *
     * @OA\Get(
     *     path="/payments",
     *     tags={"Payment"},
     *     @OA\Parameter(name="X-Mollie-Checkout-Device-UUID", in="header", required=true, @OA\Schema(type="string", format="uuid")),
     *     @OA\Response(response=200, description="OK", @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Payment")))
     * )
     */
    public function index(Request $request): ResourceCollection
    {
        $payments = Payment::device()->get();

        return PaymentResource::collection($payments);
    }

    /**
     * Create payment.
     *
     * More information: https://docs.mollie.com/reference/v2/payments-api/create-payment
     *
     * @param PaymentRequest $request
     * @return PaymentResource
     * @throws ApiException
     *
     * @OA\Post(
     *     path="/payments",
     *     tags={"Payment"},
     *     @OA\Parameter(name="X-Mollie-Checkout-Device-UUID", in="header", required=true, @OA\Schema(type="string", format="uuid")),
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(property="method", type="string", nullable=true),
     *                  @OA\Property(property="issuer", type="string", nullable=true),
     *
     *                  @OA\Property(property="amount", type="number", format="double"),
     *                  @OA\Property(property="description", type="string")
     *              )
     *          )
     *     ),
     *     @OA\Response(response=201, description="Created", @OA\JsonContent(ref="#/components/schemas/Payment")),
     *     @OA\Response(response=422, description="Unprocessable entity", @OA\JsonContent())
     * )
     */
    public function store(PaymentRequest $request): PaymentResource
    {
        $payment = Payment::make($request->all());
        $payment->device_uuid = $request->header(Device::$HEADER);
        $payment->save();

        try {
            $molliePayment = Mollie::api()->payments()->create([
                'method' => $payment->method,
                'issuer' => $request->get('issuer'),

                'amount' => [
                    'currency' => 'EUR',
                    'value' => number_format($payment->amount, 2, '.', '')
                ],
                'description' => $payment->description,

                'redirectUrl' => env('MOLLIE_DEEPLINK_PREFIX', 'mollie-checkout') . '://payments/' . $payment->id,
                'webhookUrl' => $request->getHost() !== 'localhost' ? route('payments.webhook', [$payment]) : null,
            ]);

            $payment->mollie_id = $molliePayment->id;
            $payment->url = $molliePayment->getCheckoutUrl();
            $payment->status = $molliePayment->status;
            $payment->save();
        } catch (ApiException $exception) {
            if ($exception->getCode() == 422) {
                abort(422, $exception->getMessage());
            } else {
                throw $exception;
            }
        }

        return new PaymentResource($payment);
    }

    /**
     * Show payment.
     *
     * @param int $id
     * @return PaymentResource
     *
     * @OA\Get(
     *     path="/payments/{payment_id}",
     *     tags={"Payment"},
     *     @OA\Parameter(name="X-Mollie-Checkout-Device-UUID", in="header", required=true, @OA\Schema(type="string", format="uuid")),
     *     @OA\Parameter(name="payment_id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Created", @OA\JsonContent(ref="#/components/schemas/Payment")),
     *     @OA\Response(response=404, description="Not Found", @OA\JsonContent())
     * )
     */
    public function show(int $id): PaymentResource
    {
        $payment = Payment::device()->findOrFail($id);

        return new PaymentResource($payment);
    }
}
