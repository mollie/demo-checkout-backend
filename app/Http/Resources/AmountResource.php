<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'Amount',
    properties: [
        new OA\Property('value', type: 'number', format: 'double'),
        new OA\Property('currency', type: 'string'),
    ]
)]
class AmountResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'value' => (float) $this->value,
            'currency' => (string) $this->currency,
        ];
    }
}
