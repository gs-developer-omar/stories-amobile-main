<?php

namespace App\Http\Controllers\api\v1\Swagger;

use App\Http\Controllers\api\v1\ApiController;
/**
 * @OA\Get(
 *      path="/api/v1/stories/{story_id}/story-items",
 *      summary="Получение списка элементов сториса",
 *      tags={"Story"},
 *      security={{ "apiKeyAuth": {} }},
 *          @OA\Parameter(
 *              name="phone",
 *              description="Номер телефона",
 *              required=true,
 *              example="7000801",
 *              in="query",
 *              @OA\Schema(
 *                  type="string"
 *              )
 *          ),
 *          @OA\Parameter(
 *              name="story_id",
 *              description="ID сториса",
 *              required=true,
 *              example=2,
 *              in="path",
 *              @OA\Schema(
 *                  type="integer"
 *              )
 *          ),
 *          @OA\Parameter(
 *               name="include",
 *               description="Связанные данные
 * Доступные связи: 'storyItemButtons'. Полученные вложенные данные будут отсортированы по полю - position в порядке возрастания, также is_active = true.",
 *               required=false,
 *               example="storyItemButtons",
 *               in="query",
 *               @OA\Schema(
 *                   type="string"
 *               )
 *          ),
 *          @OA\Parameter(
 *               name="sort",
 *               description="Сортировка данных
 * Сортируемые поля: 'title', 'position'. Если передать значение без знака, отсортирует в порядке возрастания, если со знаком минус (-title), отсортирует в порядке убывания.",
 *               required=false,
 *               example="position",
 *               in="query",
 *               @OA\Schema(
 *                   type="string"
 *               )
 *          ),
 *          @OA\Parameter(
 *               name="id",
 *               description="ID элемента сториса",
 *               required=false,
 *               example="",
 *               in="query",
 *               @OA\Schema(
 *                   type="integer"
 *               )
 *          ),
 *          @OA\Parameter(
 *               name="is_published",
 *               description="Опубликован
 * Информация о том, опубликован ли сторис, или нет.",
 *               required=false,
 *               example="true",
 *               in="query",
 *               @OA\Schema(
 *                   type="boolean"
 *               )
 *          ),
 *          @OA\Response(
 *               response=200,
 *               description="Ok",
 *               @OA\JsonContent(
 *                   @OA\Property(
 *                       property="data",
 *                       type="array",
 *                       @OA\Items(
 *                           type="object",
 *                           @OA\Property(property="element_id", type="integer", example=2),
 *                           @OA\Property(property="title", type="string", example="Тестовый Сторис"),
 *                       @OA\Property(property="media_type", type="string", example="media_file"),
 * *                       @OA\Property(property="file_path", type="string", example="http://stories.test/storage/stories/items/01J7BMT94V1W2D0MFYPFWEAWEB.webp"),
 * *                       @OA\Property(property="link", type="string", example="https://www.instagram.com/p/CRYgfzNnoST/?utm_medium=copy_link"),
 *                           @OA\Property(property="position", type="integer", example=1),
 *                           @OA\Property(property="is_published", type="boolean", example=true),
 *                       ),
 *                   ),
 *               ),
 *          ),
 *  ),
 *
 * @OA\Get(
 *       path="/api/v1/stories/{story_id}/story-items/{story_item_id}",
 *       summary="Получение определенного элемента сториса через story_item_id",
 *       tags={"Story"},
 *       security={{ "apiKeyAuth": {} }},
 *           @OA\Parameter(
 *               name="story_id",
 *               description="ID сториса",
 *               required=true,
 *               example=2,
 *               in="path",
 *               @OA\Schema(
 *                   type="integer"
 *               )
 *           ),
 *           @OA\Parameter(
 *               name="story_item_id",
 *               description="ID элемента сториса",
 *               required=true,
 *               example=21,
 *               in="path",
 *               @OA\Schema(
 *                   type="integer"
 *               )
 *           ),
 *           @OA\Parameter(
 *                name="phone",
 *                description="Номер телефона",
 *                required=true,
 *                example="7000801",
 *                in="query",
 *                @OA\Schema(
 *                    type="string"
 *                )
 *           ),
 *           @OA\Parameter(
 *               name="include",
 *               description="Связанные данные
 * Доступные связи: 'storyItemButtons'. Полученные вложенные данные будут отсортированы по полю - position в порядке возрастания, также is_active = true.",
 *               required=false,
 *               example="storyItemButtons",
 *               in="query",
 *               @OA\Schema(
 *                   type="string"
 *               )
 *           ),
 *           @OA\Response(
 *               response=200,
 *               description="Ok",
 *               @OA\JsonContent(
 *                   @OA\Property(
 *                       property="data",
 *                       type="object",
 *                       @OA\Property(property="element_id", type="integer", example=21),
 *                       @OA\Property(property="title", type="string", example="Тестовый Элемент Сториса"),
 *                       @OA\Property(property="media_type", type="string", example="media_file"),
 *                       @OA\Property(property="file_path", type="string", example="http://stories.test/storage/stories/items/01J7BMT94V1W2D0MFYPFWEAWEB.webp"),
 *                       @OA\Property(property="link", type="string", example="https://www.instagram.com/p/CRYgfzNnoST/?utm_medium=copy_link"),
 *                       @OA\Property(property="position", type="integer", example=1),
 *                       @OA\Property(property="is_published", type="boolean", example=true),
 *                   ),
 *               ),
 *           ),
 *  ),
 */
class B_StoryItemController extends ApiController
{
}
