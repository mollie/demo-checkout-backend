<?php

namespace App\Http\Resources;

use DateTimeInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(schema="Issuer")
 *
 * @OA\Property(property="id", type="string")
 *
 * @OA\Property(property="name", type="string")
 *
 * @OA\Property(property="image", ref="#/components/schemas/Image")
 */
class IssuerResource extends JsonResource
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

            'name' => (string) $this->name,

            'image' => new ImageResource($this->image),
        ];
    }
}
