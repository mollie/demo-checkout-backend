<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'Issuer',
    properties: [
        new OA\Property('id', type: 'string'),
        new OA\Property('name', type: 'string'),
        new OA\Property('image', ref: ImageResource::class),
    ]
)]
class IssuerResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => (string) $this->id,
            'name' => (string) $this->name,
            'image' => new ImageResource($this->image),
        ];
    }
}
