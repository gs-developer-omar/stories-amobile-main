<?php

namespace App\Http\Controllers\api\v1\Swagger;

use App\Http\Controllers\api\v1\ApiController;

/**
 * @OA\Get(
 *     path="/api/v1/stories",
 *     summary="Получение списка сторисов",
 *     tags={"Story"},
 *     security={{ "apiKeyAuth": {} }},
 *     @OA\Parameter(
 *          name="phone",
 *          description="Номер телефона",
 *          required=true,
 *          example="7000801",
 *          in="query",
 *          @OA\Schema(
 *              type="string"
 *          )
 *     ),
 *     @OA\Parameter(
 *          name="include",
 *          description="Связанные данные
 * Доступные связи: 'storyItems', 'storyItems.storyItemButtons', 'comments', 'comments.replies', 'comments.emojis'.
 *     *Подсказка*: Если нужно получить комментарии вместе с ответами и реакциями, нужно использовать include=comments.replies,comments.emojis.",
 *          required=false,
 *          example="storyItems.storyItemButtons,comments",
 *          in="query",
 *          @OA\Schema(
 *              type="string"
 *          )
 *     ),
 *     @OA\Parameter(
 *          name="sort",
 *          description="Сортировка данных
 * Сортируемые поля: 'title', 'position'. Если передать значение без знака, отсортирует в порядке возрастания, если со знаком минус (-title), отсортирует в порядке убывания.",
 *          required=false,
 *          example="-position",
 *          in="query",
 *          @OA\Schema(
 *              type="string"
 *          )
 *     ),
 *     @OA\Parameter(
 *          name="id",
 *          description="ID сториса",
 *          required=false,
 *          example="",
 *          in="query",
 *          @OA\Schema(
 *              type="integer"
 *          )
 *     ),
 *     @OA\Parameter(
 *           name="is_published",
 *           description="Опубликован
 * Информация о том, опубликован ли сторис, или нет.",
 *           required=false,
 *           example="true",
 *           in="query",
 *           @OA\Schema(
 *               type="boolean"
 *           )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Ok",
 *         @OA\JsonContent(
 *             @OA\Property(
 *             property="data",
 *             type="array",
 *                 @OA\Items(
 *                     type="object",
 *                     @OA\Property(property="id", type="integer", example=2),
 *                     @OA\Property(property="title", type="string", example="Тестовый Сторис"),
 *                     @OA\Property(property="icon_url", type="string", example="http://stories.test/storage/stories/icons/01J7368AAS4Q399AXFC8R2X6DP.webp"),
 *                     @OA\Property(property="position", type="integer", example=1),
 *                     @OA\Property(property="is_published", type="boolean", example=true),
 *                     @OA\Property(property="likes_count", type="integer", example=2),
 *                     @OA\Property(property="views_count", type="integer", example=1),
 *                 ),
 *             ),
 *         ),
 *     ),
 * ),
 *
 * @OA\Get(
 *      path="/api/v1/stories/{story_id}",
 *      summary="Получение сториса по ID",
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
 *              name="include",
 *              description="Связанные данные
 *  Доступные связи: 'storyItems', 'storyItems.storyItemButtons', 'comments', 'comments.replies', 'comments.emojis'.
 *     Подсказка*: Если нужно получить комментарии вместе с ответами и реакциями, нужно использовать include=comments.replies,comments.emojis.",
 *              required=false,
 *              example="storyItems.storyItemButtons,comments",
 *              in="query",
 *              @OA\Schema(
 *                  type="string"
 *              )
 *          ),
 *          @OA\Response(
 *              response=200,
 *              description="Ok",
 *              @OA\JsonContent(
 *                  @OA\Property(
 *                      property="data",
 *                      type="object",
 *                      @OA\Property(property="id", type="integer", example=2),
 *                      @OA\Property(property="title", type="string", example="Тестовый Сторис"),
 *                      @OA\Property(property="icon_url", type="string", example="http://stories.test/storage/stories/icons/01J7368AAS4Q399AXFC8R2X6DP.webp"),
 *                      @OA\Property(property="position", type="integer", example=1),
 *                      @OA\Property(property="is_published", type="boolean", example=true),
 *                      @OA\Property(property="likes_count", type="integer", example=2),
 *                      @OA\Property(property="views_count", type="integer", example=1),
 *                  ),
 *              ),
 *          ),
 * ),
 *
 * @OA\POST(
 *       path="/api/v1/stories/{story_id}/watch",
 *       summary="Просмотр сториса",
 *       tags={"Story"},
 *       security={{ "apiKeyAuth": {} }},
 *           @OA\Parameter(
 *                name="story_id",
 *                description="ID сториса",
 *                required=true,
 *                example="2",
 *                in="path",
 *                @OA\Schema(
 *                    type="integer"
 *                )
 *           ),
 *           @OA\RequestBody(
 *                required=true,
 *                @OA\JsonContent(
 *                    allOf={
 *                        @OA\Schema(
 *                            @OA\Property(property="phone", type="string", example="7000801")
 *                        )
 *                    }
 *                )
 *           ),
 *           @OA\Response(
 *               response=201,
 *               description="Created",
 *               @OA\JsonContent(
 *                   @OA\Property(property="event", type="string", example="CREATED"),
 *                   @OA\Property(property="message", type="string", example="Просмотр сториса был успешно зафиксирован"),
 *                   @OA\Property(
 *                       property="data",
 *                       type="object",
 *                       @OA\Property(property="phone", type="string", example="7000801"),
 *                       @OA\Property(property="story_id", type="integer", example="2"),
 *                   ),
 *               ),
 *           ),
 *  ),
 *
 * @OA\POST(
 *        path="/api/v1/stories/{story_id}/like",
 *        summary="Лайк сториса",
 *        tags={"Story"},
 *        security={{ "apiKeyAuth": {} }},
 *            @OA\Parameter(
 *                 name="story_id",
 *                 description="ID сториса",
 *                 required=true,
 *                 example="2",
 *                 in="path",
 *                 @OA\Schema(
 *                     type="integer"
 *                 )
 *            ),
 *            @OA\RequestBody(
 *                 required=true,
 *                 @OA\JsonContent(
 *                     allOf={
 *                         @OA\Schema(
 *                             @OA\Property(property="phone", type="string", example="7000801")
 *                         )
 *                     }
 *                 )
 *            ),
 *            @OA\Response(
 *                response=201,
 *                description="Created",
 *                @OA\JsonContent(
 *                    @OA\Property(property="event", type="string", example="CREATED"),
 *                    @OA\Property(property="message", type="string", example="Лайк был успешно создан"),
 *                    @OA\Property(
 *                        property="data",
 *                        type="object",
 *                        @OA\Property(property="phone", type="string", example="7000801"),
 *                        @OA\Property(property="story_id", type="integer", example=2),
 *                    ),
 *                ),
 *            ),
 *   ),
 */
class A_StoryController extends ApiController
{
}
