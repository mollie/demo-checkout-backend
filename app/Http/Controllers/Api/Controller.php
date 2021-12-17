<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller as BaseController;

/**
 * @OA\Info(
 *     title=SWAGGER_APP_NAME,
 *     description=SWAGGER_APP_DESCRIPTION,
 *     version="1.0.0",
 *     @OA\Contact(
 *         name="Webuildapps",
 *         email="hello@webuildapps.com"
 *     ),
 *     @OA\License(
 *         name="MIT"
 *     )
 * )
 *
 * @OA\Server(
 *     description="Default",
 *     url=SWAGGER_APP_URL
 * )
 */
class Controller extends BaseController
{
    //
}
