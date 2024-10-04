<?php

namespace App\Http\Controllers\api\v1\Swagger;


use App\Http\Controllers\api\v1\ApiController;
/**
 *  @OA\Get(
 *     path="/api/v1/stories/{story_id}/comments/{comment_id}/reactions",
 *     summary="Получение списка реакций к определенному комментарию",
 *     tags={"Comments"},
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
 *           name="story_id",
 *           description="ID сториса",
 *           required=true,
 *           example="2",
 *           in="path",
 *           @OA\Schema(
 *               type="integer"
 *           )
 *     ),
 *     @OA\Parameter(
 *           name="comment_id",
 *           description="ID комментария",
 *           required=true,
 *           example="32",
 *           in="path",
 *           @OA\Schema(
 *               type="string"
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
 *                     @OA\Property(property="id", type="integer", example=13),
 *                     @OA\Property(property="phone", type="string", example="7000801"),
 *                     @OA\Property(property="story_id", type="integer", example=2),
 *                     @OA\Property(property="comment_id", type="integer", example=31),
 *                     @OA\Property(property="emoji", type="string", example="😯"),
 *                 ),
 *             ),
 *         ),
 *     ),
 * ),
 *
 * @OA\POST(
 *        path="/api/v1/stories/{story_id}/comments/{comment_id}/reactions",
 *        summary="Создание реакции к определенному комментарию",
 *        tags={"Comments"},
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
 *            @OA\Parameter(
 *                  name="comment_id",
 *                  description="ID комментария",
 *                  required=true,
 *                  example="31",
 *                  in="path",
 *                  @OA\Schema(
 *                      type="integer"
 *                  )
 *            ),
 *            @OA\RequestBody(
 *                 required=true,
 *                 @OA\JsonContent(
 *                     allOf={
 *                         @OA\Schema(
 *                             @OA\Property(property="phone", type="string", example="7000801"),
 *                             @OA\Property(property="emoji", type="string", example="🙌"),
 *                         )
 *                     }
 *                 )
 *            ),
 *            @OA\Response(
 *                response=201,
 *                description="Created",
 *                @OA\JsonContent(
 *                    @OA\Property(property="event", type="string", example="CREATED"),
 *                    @OA\Property(property="message", type="string", example="Реакция 🙌 была успешна добавлена к комментарию"),
 *                    @OA\Property(
 *                        property="data",
 *                        type="object",
 *                        @OA\Property(property="id", type="integer", example=19),
 *                        @OA\Property(property="phone", type="string", example="7000803"),
 *                        @OA\Property(property="story_id", type="integer", example=2),
 *                        @OA\Property(property="comment_id", type="integer", example=31),
 *                        @OA\Property(property="emoji", type="string", example="🙌"),
 *                    ),
 *                ),
 *            ),
 *   ),
 *
 * @OA\DELETE(
 *       path="/api/v1/stories/{story_id}/comments/{comment_id}/reactions",
 *       summary="Удаление комментария по ID у определенного сториса",
 *       tags={"Comments"},
 *       security={{ "apiKeyAuth": {} }},
 *           @OA\Parameter(
 *                  name="story_id",
 *                  description="ID сториса",
 *                  required=true,
 *                  example="2",
 *                  in="path",
 *                  @OA\Schema(
 *                      type="integer"
 *                  )
 *           ),
 *           @OA\Parameter(
 *                   name="comment_id",
 *                   description="ID комментария",
 *                   required=true,
 *                   example="31",
 *                   in="path",
 *                   @OA\Schema(
 *                       type="integer"
 *                   )
 *           ),
 *           @OA\RequestBody(
 *                  required=true,
 *                  @OA\JsonContent(
 *                      allOf={
 *                          @OA\Schema(
 *                              @OA\Property(property="phone", type="string", example="7000801")
 *                          )
 *                      }
 *                  )
 *          ),
 *      @OA\Response(
 *            response=201,
 *            description="DELETED",
 *            @OA\JsonContent(
 *                @OA\Property(property="event", type="string", example="DELETED"),
 *                @OA\Property(property="message", type="string", example="Реакция была успешно удалена"),
 *                @OA\Property(
 *                property="data",
 *                type="object",
 *                @OA\Property(property="phone", type="string", example="7000803"),
 *                @OA\Property(property="story_id", type="integer", example="2"),
 *                @OA\Property(property="comment_id", type="integer", example="31"),
 *                ),
 *            ),
 *        ),
 *  )
 */
class E_EmojiReactionController extends ApiController
{
}
