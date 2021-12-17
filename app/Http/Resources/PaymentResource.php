<?php

namespace App\Http\Resources;

use DateTimeInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(schema="Payment")
 *
 * @OA\Property(property="id", type="integer")
 *
 * @OA\Property(property="mollie_id", type="string")
 *
 * @OA\Property(property="method", type="string", nullable=true)
 * @OA\Property(property="issuer", type="string", nullable=true)
 *
 * @OA\Property(property="amount", type="number", format="double")
 * @OA\Property(property="description", type="string")
 *
 * @OA\Property(property="url", type="string", format="uri")
 * @OA\Property(property="status", type="string", enum={"open", "canceled", "pending", "expired", "failed", "paid"})
 *
 * @OA\Property(property="created_at", type="string", format="date-time")
 * @OA\Property(property="updated_at", type="string", format="date-time")
 */
class PaymentResource extends JsonResource
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
            'id' => $this->id,

            'mollie_id' => $this->mollie_id,

            'method' => $this->method,
            'issuer' => $this->issuer,

            'amount' => $this->amount,
            'description' => $this->description,

            'url' => $this->url,
            'status' => $this->status,

            'created_at' => $this->created_at->format(DateTimeInterface::ATOM),
            'updated_at' => $this->updated_at->format(DateTimeInterface::ATOM),
        ];
    }
}
