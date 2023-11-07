<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'Method',
    properties: [
        new OA\Property('id', type: 'string'),
        new OA\Property('description', type: 'string'),
        new OA\Property('minimum_mount', ref: AmountResource::class),
        new OA\Property('maximum_mount', ref: AmountResource::class, nullable: true),
        new OA\Property('image', ref: ImageResource::class),
        new OA\Property('issuers', type: 'array', items: new OA\Items(ref: IssuerResource::class), nullable: true),
        new OA\Property('pricing', type: 'array', items: new OA\Items(ref: PriceResource::class), nullable: true),
    ]
)]
class MethodResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => (string) $this->id,
            'description' => (string) $this->description,
            'minimum_mount' => new AmountResource($this->minimumAmount),
            'maximum_mount' => new AmountResource($this->maximumAmount),
            'image' => new ImageResource($this->image),
            'issuers' => isset($this->issuers) && count($this->issuers) > 0 ? IssuerResource::collection($this->issuers) : null,
            'pricing' => isset($this->pricing) && count($this->pricing) > 0 ? PriceResource::collection($this->pricing) : null,
        ];
    }
}
