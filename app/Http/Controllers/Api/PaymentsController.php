<?php

namespace App\Http\Controllers\Api;

use App\Http\Middleware\Device;
use App\Http\Requests\PaymentRequest;
use App\Http\Resources\PaymentResource;
use App\Models\Payment;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Mollie\Api\Exceptions\ApiException;
use Mollie\Laravel\Facades\Mollie;
use OpenApi\Attributes as OA;

class PaymentsController extends Controller
{
    #[OA\Get(
        path: '/payments',
        summary: 'List payments.',
        tags: ['Payment'],
        parameters: [
            new OA\Parameter(name: 'X-Mollie-Checkout-Device-UUID', in: 'header', required: true, schema: new OA\Schema(type: 'string', format: 'uuid', default: '00000000-0000-0000-0000-000000000000')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Ok', content: new OA\JsonContent(properties: [
                new OA\Property(property: 'data', type: 'array', items: new OA\Items(ref: PaymentResource::class)),
            ])),
            new OA\Response(response: 400, description: 'Bad Request', content: new OA\JsonContent),
        ]
    )]
    public function index(): ResourceCollection
    {
        $payments = Payment::device()->get();

        return PaymentResource::collection($payments);
    }

    #[OA\Post(
        path: '/payments',
        description: 'More information: https://docs.mollie.com/reference/v2/payments-api/create-payment',
        summary: 'Create payment',
        requestBody: new OA\RequestBody(content: new OA\MediaType(
            mediaType: 'application/json',
            schema: new OA\Schema(properties: [
                new OA\Property('method', type: 'string', default: null, nullable: true),
                new OA\Property('issuer', type: 'string', default: null, nullable: true),
                new OA\Property('amount', type: 'number', format: 'double', default: '13.37'),
                new OA\Property('description', type: 'string', default: 'Test payment'),
            ])
        )),
        tags: ['Payment'],
        parameters: [
            new OA\Parameter(name: 'X-Mollie-Checkout-Device-UUID', in: 'header', required: true, schema: new OA\Schema(type: 'string', format: 'uuid', default: '00000000-0000-0000-0000-000000000000')),
        ],
        responses: [
            new OA\Response(response: 201, description: 'Created', content: new OA\JsonContent(ref: PaymentResource::class)),
            new OA\Response(response: 400, description: 'Bad Request', content: new OA\JsonContent),
            new OA\Response(response: 422, description: 'Unprocessable Content', content: new OA\JsonContent),
        ]
    )]
    public function store(PaymentRequest $request): PaymentResource
    {
        $payment = Payment::make($request->all());
        $payment->device_uuid = $request->header(Device::HEADER);
        $payment->save();

        try {
            $molliePayment = Mollie::api()->payments()->create([
                'method' => $payment->method,
                'issuer' => $request->get('issuer'),

                'amount' => [
                    'currency' => 'EUR',
                    'value' => number_format($payment->amount, 2, '.', ''),
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

    #[OA\Get(
        path: '/payments/{payment_id}',
        summary: 'Show payment.',
        tags: ['Payment'],
        parameters: [
            new OA\Parameter(name: 'X-Mollie-Checkout-Device-UUID', in: 'header', required: true, schema: new OA\Schema(type: 'string', format: 'uuid', default: '00000000-0000-0000-0000-000000000000')),
            new OA\Parameter(name: 'payment_id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Ok', content: new OA\JsonContent(ref: PaymentResource::class)),
            new OA\Response(response: 400, description: 'Bad Request', content: new OA\JsonContent),
            new OA\Response(response: 404, description: 'Not Found', content: new OA\JsonContent),
        ]
    )]
    public function show(int $id): PaymentResource
    {
        $payment = Payment::device()->findOrFail($id);

        return new PaymentResource($payment);
    }
}
