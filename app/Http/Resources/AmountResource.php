<?php

namespace App\Http\Resources;

use DateTimeInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(schema="Amount")
 *
 * @OA\Property(property="value", type="number", format="double")
 * @OA\Property(property="currency", type="string")
 */
class AmountResource extends JsonResource
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
            'value' => (double) $this->value,
            'currency' => (string) $this->currency,
        ];
    }
}
