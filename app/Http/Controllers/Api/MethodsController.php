<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\MethodResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Validation\ValidationException;
use Mollie\Api\Exceptions\ApiException;
use Mollie\Laravel\Facades\Mollie;

class MethodsController extends Controller
{
    /**
     * List (active) payment methods by amount.
     *
     * More information: https://docs.mollie.com/reference/v2/methods-api/list-methods
     *
     * @param Request $request
     * @return ResourceCollection
     * @throws ApiException
     * @throws ValidationException
     *
     * @OA\Get(
     *     path="/methods",
     *     tags={"Method"},
     *     @OA\Parameter(name="amount", in="query", required=false, @OA\Schema(type="number", format="double")),
     *     @OA\Response(response=200, description="OK", @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Method")))
     * )
     */
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
