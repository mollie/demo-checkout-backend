<?php

namespace App\Models;

use App\Http\Middleware\Device;
use App\Models\Enums\PaymentStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'method',
        'issuer',

        'amount',
        'description',
    ];

    protected $casts = [
        'id' => 'int',
        'mollie_id' => 'string',

        'method' => 'string',
        'issuer' => 'string',

        'amount' => 'double',
        'description' => 'string',

        'url' => 'string',
        'status' => PaymentStatus::class,

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderByDesc('id');
        });
    }

    public function scopeDevice(Builder $builder): void
    {
        $builder->where('device_uuid', request()->header(Device::HEADER));
    }
}
