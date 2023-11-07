<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\MethodResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Mollie\Api\Exceptions\ApiException;
use Mollie\Laravel\Facades\Mollie;
use OpenApi\Attributes as OA;

class MethodsController extends Controller
{
    #[OA\Get(
        path: '/methods',
        description: 'More information: https://docs.mollie.com/reference/v2/methods-api/list-methods',
        summary: 'List (active) payment methods by amount.',
        tags: ['Method'],
        parameters: [
            new OA\Parameter(name: 'amount', in: 'query', required: false, schema: new OA\Schema(type: 'number', format: 'double')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Ok', content: new OA\JsonContent(properties: [
                new OA\Property(property: 'data', type: 'array', items: new OA\Items(ref: MethodResource::class)),
            ])),
            new OA\Response(response: 422, description: 'Unprocessable Content', content: new OA\JsonContent),
        ]
    )]
    public function index(Request $request): ResourceCollection
    {
        $this->validate($request, [
            'amount' => [
                'regex:/^\d{1,8}(\.\d{0,2})?$/',
            ],
        ]);

        $parameters = [
            'include' => 'issuers,pricing',
        ];
        if ($request->has('amount')) {
            $parameters['amount'] = [
                'currency' => 'EUR',
                'value' => number_format($request->get('amount'), 2, '.', ''),
            ];
        }

        try {
            return MethodResource::collection(
                Mollie::api()->methods()->allActive($parameters)->getArrayCopy()
            );
        } catch (ApiException $exception) {
            if ($exception->getCode() == 422) {
                abort(422, $exception->getMessage());
            } else {
                throw $exception;
            }
        }
    }
}
