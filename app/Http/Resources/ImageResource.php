<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'Image',
    properties: [
        new OA\Property('size_1x', type: 'string', format: 'uri'),
        new OA\Property('size_2x', type: 'string', format: 'uri'),
        new OA\Property('svg', type: 'string', format: 'uri'),
    ]
)]
class ImageResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'size_1x' => (string) $this->size1x,
            'size_2x' => (string) $this->size2x,
            'svg' => (string) $this->svg,
        ];
    }
}
