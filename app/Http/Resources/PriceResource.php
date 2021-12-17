<?php

namespace App\Http\Resources;

use DateTimeInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(schema="Price")
 *
 * @OA\Property(property="description", type="string")
 * @OA\Property(property="fixed", ref="#/components/schemas/Amount")
 * @OA\Property(property="variable", type="number", format="double")
 * @OA\Property(property="fee_region", type="string", nullable=true)
 */
class PriceResource extends JsonResource
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
            'description' => (string) $this->description,
            'fixed' => new AmountResource($this->fixed),
            'variable' => (double)$this->variable,
            'fee_region' => isset($this->feeRegion) ? (string) $this->feeRegion : null,
        ];
    }
}
