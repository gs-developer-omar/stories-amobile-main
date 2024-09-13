<?php

namespace App\Http\Controllers\api\v1\Swagger;

use App\Http\Controllers\api\v1\ApiController;

/**
 * @OA\Get(
 *     path="/api/v1/story-items/{story_item_id}/story-item-buttons",
 *     summary="Получение списка кнопок для элемента сториса через story_item_id",
 *     tags={ "Story" },
 *     security={{ "apiKeyAuth": {} }},
 *     @OA\Parameter(
 *         name="story_item_id",
 *         description="ID элемента сториса",
 *         required=true,
 *         example=21,
 *         in="path",
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\Parameter(
 *         name="phone",
 *         description="",
 *         required=true,
 *         example="7000801",
 *         in="query",
 *         @OA\Schema(
 *             type="string"
 *         )
 *     ),
 *     @OA\Parameter(
 *         name="sort",
 *         description="",
 *         required=false,
 *         example="position",
 *         in="query",
 *         @OA\Schema(
 *             type="string"
 *         )
 *     ),
 *     @OA\Parameter(
 *         name="id",
 *         description="",
 *         required=false,
 *         example="",
 *         in="query",
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\Parameter(
 *         name="is_active",
 *         description="",
 *         required=false,
 *         example=true,
 *         in="query",
 *         @OA\Schema(
 *             type="boolean"
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Ok",
 *         @OA\JsonContent(
 *             @OA\Property(property="data", type="array",
 *                 @OA\Items(
 *                     type="object",
 *                     @OA\Property(property="id", type="integer", example=12),
 *                     @OA\Property(property="button_text", type="string", example="Yes"),
 *                     @OA\Property(property="media_url", type="string", example="http://stories.test/storage/stories/items/buttons/01J7DK35EP99WJ4VBXMV3HN48Q.webp"),
 *                     @OA\Property(property="position", type="integer", example=2),
 *                     @OA\Property(property="is_active", type="boolean", example=true),
 *                 )
 *             )
 *         )
 *     )
 * )
 */
class StoryItemStoryItemButtonsController extends ApiController
{
}
