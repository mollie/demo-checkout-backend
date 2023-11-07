<?php

namespace App\Http\Resources;

use App\Models\Enums\PaymentStatus;
use DateTimeInterface;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'Payment',
    properties: [
        new OA\Property('id', type: 'string'),
        new OA\Property('mollie_id', type: 'string'),
        new OA\Property('method', type: 'string', nullable: true),
        new OA\Property('issuer', type: 'string', nullable: true),
        new OA\Property('amount', type: 'number', format: 'double'),
        new OA\Property('description', type: 'string'),
        new OA\Property('url', type: 'string', format: 'uri'),
        new OA\Property('status', ref: PaymentStatus::class),
        new OA\Property(property: 'created_at', type: 'string', format: 'date-time'),
        new OA\Property(property: 'updated_at', type: 'string', format: 'date-time'),
    ]
)]
class PaymentResource extends JsonResource
{
    public function toArray($request): array
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
