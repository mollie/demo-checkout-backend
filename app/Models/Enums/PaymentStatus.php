<?php

namespace App\Models\Enums;

use OpenApi\Attributes as OA;

#[OA\Schema(type: 'string')]
enum PaymentStatus: string
{
    case OPEN = 'open';
    case CANCELED = 'canceled';
    case PENDING = 'pending';
    case EXPIRED = 'expired';
    case FAILED = 'failed';
    case PAID = 'paid';
}
