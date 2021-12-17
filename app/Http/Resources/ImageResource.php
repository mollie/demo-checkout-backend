<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(schema="Image")
 *
 * @OA\Property(property="size_1x", type="string", format="uri")
 * @OA\Property(property="size_2x", type="string", format="uri")
 *
 * @OA\Property(property="svg", type="string", format="uri")
 */
class ImageResource extends JsonResource
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
            'size_1x' => (string)$this->size1x,
            'size_2x' => (string)$this->size2x,

            'svg' => (string)$this->svg,
        ];
    }
}
