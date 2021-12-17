<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class Device
{
    static $HEADER = 'x-mollie-checkout-device-uuid';

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!$request->hasHeader(static::$HEADER)) {
            abort(400, '`X-Mollie-Checkout-Device-UUID` header is missing.');
        }

        if (!Str::isUuid($request->header(static::$HEADER))) {
            abort(400, '`X-Mollie-Checkout-Device-UUID` header is invalid.');
        }

        return $next($request);
    }
}
