<?php

namespace App\Http\Controllers\api\v1\Swagger;

use App\Http\Controllers\Controller;

/**
 * @OA\Info(
 *     title="Stories API Documentation",
 *     version="1.0.0"
 * ),
 * @OA\PathItem(
 *     path="/api/"
 * ),
 * @OA\Components(
 *     @OA\SecurityScheme(
 *          securityScheme="apiKeyAuth",
 *          type="apiKey",
 *          in="header",
 *          name="apiKey"
 *     )
 * )
 */
class SwaggerMainController extends Controller
{
    //
}
