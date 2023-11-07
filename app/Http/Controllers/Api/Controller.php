<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller as BaseController;
use OpenApi\Attributes as OA;

#[OA\Info(
    version: '1.1.0',
    description: SWAGGER_APP_DESCRIPTION,
    title: SWAGGER_APP_NAME,
)]
#[OA\Server(
    url: SWAGGER_APP_URL,
)]
class Controller extends BaseController
{
    //
}
