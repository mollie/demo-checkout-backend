<?php

namespace App\Http\Resources;

use DateTimeInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Mollie\Api\Resources\IssuerCollection;

/**
 * @OA\Schema(schema="Method")
 *
 * @OA\Property(property="id", type="string")
 *
 * @OA\Property(property="description", type="string")
 *
 * @OA\Property(property="minimum_mount", ref="#/components/schemas/Amount")
 * @OA\Property(property="maximum_mount", ref="#/components/schemas/Amount", nullable=true)
 *
 * @OA\Property(property="image", ref="#/components/schemas/Image")
 *
 * @OA\Property(property="issuers", type="array", @OA\Items(ref="#/components/schemas/Issuer"), nullable=true)
 * @OA\Property(property="pricing", type="array", @OA\Items(ref="#/components/schemas/Price"), nullable=true)
 */
class MethodResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => (string) $this->id,

            'description' => (string) $this->description,

            'minimum_mount' => new AmountResource($this->minimumAmount),
            'maximum_mount' => new AmountResource($this->maximumAmount),

            'image' => new ImageResource($this->image),

            'issuers' => isset($this->issuers) && count($this->issuers) > 0 ? IssuerResource::collection($this->issuers): null,
            'pricing' => isset($this->pricing) && count($this->pricing) > 0 ? PriceResource::collection($this->pricing) : null,
        ];
    }
}
