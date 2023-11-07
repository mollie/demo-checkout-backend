<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'Price',
    properties: [
        new OA\Property('description', type: 'string'),
        new OA\Property('fixed', ref: AmountResource::class),
        new OA\Property('variable', type: 'number', format: 'double'),
        new OA\Property('fee_region', type: 'string', nullable: true),
    ]
)]
class PriceResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'description' => (string) $this->description,
            'fixed' => new AmountResource($this->fixed),
            'variable' => (float) $this->variable,
            'fee_region' => isset($this->feeRegion) ? (string) $this->feeRegion : null,
        ];
    }
}
