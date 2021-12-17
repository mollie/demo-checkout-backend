<?php

namespace App\Models;

use App\Http\Middleware\Device;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    public static $STATUS_OPEN = 'open';
    public static $STATUS_CANCELED = 'canceled';
    public static $STATUS_PENDING = 'pending';
    public static $STATUS_EXPIRED = 'expired';
    public static $STATUS_FAILED = 'failed';
    public static $STATUS_PAID = 'paid';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'method',
        'issuer',

        'amount',
        'description',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'int',
        'mollie_id' => 'string',

        'method' => 'string',
        'issuer' => 'string',

        'amount' => 'double',
        'description' => 'string',

        'url' => 'string',
        'status' => 'string',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderByDesc('id');
        });
    }

    /**
     * Scope query to only include payments created by the device set in the header.
     *
     * @return Builder
     */
    public function scopeDevice(): Builder
    {
        return $this->where('device_uuid', request()->header(Device::$HEADER));
    }
}
