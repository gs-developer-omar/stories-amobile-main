<?php

namespace App\Http\Controllers\api\v1\Swagger;

use App\Http\Controllers\api\v1\ApiController;

/**
 * @OA\Get(
 *     path="/api/v1/stories/{story_id}/comments",
 *     summary="Получение списка комментариев к определенному сторису.",
 *     tags={"Comments"},
 *     security={{ "apiKeyAuth": {} }},
 *     @OA\Parameter(
 *           name="story_id",
 *           description="ID сториса",
 *           required=true,
 *           example=2,
 *           in="path",
 *           @OA\Schema(type="integer")
 *     ),
 *     @OA\Parameter(
 *          name="phone",
 *          description="Номер телефона",
 *          required=true,
 *          example="7000801",
 *          in="query",
 *          @OA\Schema(type="string")
 *     ),
 *     @OA\Parameter(
 *          name="include",
 *          description="Связанные данные. Доступные связи: 'replies'. Связанные данные (ответы на комментарии) будут отсортированы по полю updated_at в порядке убывания.",
 *          required=false,
 *          example="replies",
 *          in="query",
 *          @OA\Schema(type="string")
 *     ),
 *     @OA\Parameter(
 *          name="sort",
 *          description="Сортировка данных. Сортируемые поля: 'updated_at'. Если передать значение без знака, отсортирует в порядке возрастания, если со знаком минус (-updated_at), отсортирует в порядке убывания.",
 *          required=false,
 *          example="-updated_at",
 *          in="query",
 *          @OA\Schema(type="string")
 *     ),
 *     @OA\Parameter(
 *          name="id",
 *          description="ID комментария",
 *          required=false,
 *          example="",
 *          in="query",
 *          @OA\Schema(type="integer")
 *     ),
 *     @OA\Parameter(
 *           name="parent_id",
 *           description="ID родительского комментария. В ответе будет список комментариев, которые являются ответами на комментарий с указанным parent_id.",
 *           required=false,
 *           example="",
 *           in="query",
 *           @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Ok",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="data",
 *                 type="array",
 *                 @OA\Items(
 *                     type="object",
 *                     @OA\Property(property="id", type="integer", example=3),
 *                     @OA\Property(property="story_id", type="integer", example=2),
 *                     @OA\Property(property="phone", type="string", example="7000801"),
 *                     @OA\Property(property="content", type="string", example="Тестовый комментарий"),
 *                     @OA\Property(property="updated_at", type="string", example="16:48:54 27-09-2024"),
 *                     @OA\Property(property="parent_id", type="integer", example=null)
 *                 )
 *             )
 *         )
 *     )
 * ),
 *
 * @OA\Get(
 *      path="/api/v1/stories/{story_id}/comments/{comment_id}",
 *      summary="Получение комментария по id к определенному сторису",
 *      tags={"Comments"},
 *      security={{ "apiKeyAuth": {} }},
 *      @OA\Parameter(
 *          name="story_id",
 *          description="ID сториса",
 *          required=true,
 *          example=2,
 *          in="path",
 *          @OA\Schema(type="integer")
 *      ),
 *      @OA\Parameter(
 *          name="comment_id",
 *          description="ID комментария",
 *          required=true,
 *          example=3,
 *          in="path",
 *          @OA\Schema(type="integer")
 *      ),
 *      @OA\Parameter(
 *          name="phone",
 *          description="Номер телефона",
 *          required=true,
 *          example="7000801",
 *          in="query",
 *          @OA\Schema(type="string")
 *      ),
 *      @OA\Parameter(
 *          name="include",
 *          description="Связанные данные. Доступные связи: 'replies'. Связанные данные (ответы на комментарии) будут отсортированы по полю updated_at в порядке убывания.",
 *          required=false,
 *          example="replies",
 *          in="query",
 *          @OA\Schema(type="string")
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="Ok",
 *          @OA\JsonContent(
 *              @OA\Property(
 *                  property="data",
 *                  type="object",
 *                  @OA\Property(property="id", type="integer", example=3),
 *                  @OA\Property(property="story_id", type="integer", example=2),
 *                  @OA\Property(property="phone", type="string", example="7000801"),
 *                  @OA\Property(property="content", type="string", example="Тестовый комментарий"),
 *                  @OA\Property(property="updated_at", type="string", example="16:48:54 27-09-2024"),
 *                  @OA\Property(property="parent_id", type="integer", example=null)
 *              )
 *          )
 *      )
 * ),
 *
 * @OA\POST(
 *      path="/api/v1/stories/{story_id}/comments",
 *      summary="Создание комментария к определенному сторису",
 *      tags={"Comments"},
 *      security={{ "apiKeyAuth": {} }},
 *      @OA\Parameter(
 *          name="story_id",
 *          description="ID сториса",
 *          required=true,
 *          example="2",
 *          in="path",
 *          @OA\Schema(type="integer")
 *      ),
 *      @OA\RequestBody(
 *          required=true,
 *          @OA\JsonContent(
 *              @OA\Property(property="content", type="string", example="Тестовый коммент"),
 *              @OA\Property(property="parent_id", type="integer", example=1)
 *          )
 *      ),
 *      @OA\Response(
 *          response=201,
 *          description="Created",
 *          @OA\JsonContent(
 *              @OA\Property(property="id", type="integer", example=3),
 *              @OA\Property(property="story_id", type="integer", example=2),
 *              @OA\Property(property="phone", type="string", example="7000801"),
 *              @OA\Property(property="content", type="string", example="Тестовый комментарий"),
 *              @OA\Property(property="updated_at", type="string", example="16:48:54 27-09-2024"),
 *              @OA\Property(property="parent_id", type="integer", example=null)
 *          )
 *      )
 * ),
 *
 * @OA\DELETE(
 *      path="/api/v1/stories/{story_id}/comments/{comment_id}",
 *      summary="Удаление комментария по ID у определенного сториса",
 *      tags={"Comments"},
 *      security={{ "apiKeyAuth": {} }},
 *      @OA\Parameter(
 *          name="story_id",
 *          description="ID сториса",
 *          required=true,
 *          example="2",
 *          in="path",
 *          @OA\Schema(type="integer")
 *      ),
 *      @OA\Parameter(
 *          name="comment_id",
 *          description="ID комментария",
 *          required=true,
 *          example=3,
 *          in="path",
 *          @OA\Schema(type="integer")
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="Ok",
 *          @OA\JsonContent(
 *              @OA\Property(property="message", type="string", example="Комментарий к сторису был успешно удален.")
 *          )
 *      )
 * )
 */
class StoryStoryCommentsController extends ApiController
{
}
