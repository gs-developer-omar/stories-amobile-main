<?php

namespace App\Http\Controllers\api\v1;

use App\Enums\api\v1\ERROR_TYPE;
use App\Enums\api\v1\HTTP_EVENT;
use App\Http\Filters\v1\StoryCommentFilter;
use App\Http\Requests\v1\StoreStoryCommentRequest;
use App\Http\Requests\v1\StoryCommentRequest;
use App\Http\Requests\v1\UpdateStoryCommentRequest;
use App\Http\Resources\v1\StoryCommentResource;
use App\Models\AmobileUser;
use App\Models\Story;
use App\Models\StoryComment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response;

class StoryCommentController extends ApiController
{
    public function index(StoryCommentRequest $request, Story $story, StoryCommentFilter $filters): AnonymousResourceCollection
    {
        AmobileUser::authenticateAmobileUser($request->input('phone'));

        $storyComments = StoryComment::filter($filters)->where('story_id', $story->id);

        if (in_array('parentComment', $this->validRelationships(StoryComment::$relationships))) {
            return StoryCommentResource::collection($storyComments->get());
        }

        return StoryCommentResource::collection($storyComments->whereNull('parent_id')->get());
    }

    public function show(StoryCommentRequest $request, Story $story, int $storyCommentId): StoryCommentResource
    {
        $phone = $request->input('phone');
        AmobileUser::authenticateAmobileUser($phone);

        $storyComment = StoryComment::where([
            'id' => $storyCommentId,
            'story_id' => $story->id,
        ])->firstOrFail();

        $storyComment->load($this->validRelationships(StoryComment::$relationships));

        return new StoryCommentResource($storyComment);
    }

    public function store(StoreStoryCommentRequest $request, Story $story): JsonResponse
    {
        $phone = $request->input('phone');
        AmobileUser::authenticateAmobileUser($phone);

        if (!is_null($request->input('parent_id'))) {
            $parent_comment = StoryComment::where([
                'story_id' => $story->id,
                'id' => $request->input('parent_id'),
            ])->first();
            if (empty($parent_comment)) {
                return response()->json([
                    'errors' => [
                        [
                            "type" => ERROR_TYPE::HTTP_UNPROCESSABLE_ENTITY,
                            'status' => Response::HTTP_UNPROCESSABLE_ENTITY,
                            "message" => "Комментарий с указанным parent id не существует для данного сториса"
                        ]
                    ]
                ], 422);
            }
        }

        $storyComment = StoryComment::create([
            'story_id' => $story->id,
            'phone' => $phone,
            'content' => $request->input('content'),
            'parent_id' => $request->input('parent_id') ?? null,
        ]);

        return response()->json([
            'event' => HTTP_EVENT::CREATED,
            'message' => 'Комментарий к сторису был успешно создан',
            'data' => new StoryCommentResource($storyComment)
        ]);
    }

    public function update(UpdateStoryCommentRequest $request, Story $story, int $storyCommentId): StoryCommentResource
    {
        $phone = $request->input('phone');
        AmobileUser::authenticateAmobileUser($phone);

        $storyComment = StoryComment::where([
            'id' => $storyCommentId,
            'story_id' => $story->id,
            'phone' => $phone,
        ])->firstOrFail();

        $storyComment->updateOrFail([
            'content' => $request->input('content')
        ]);

        return new StoryCommentResource($storyComment);
    }

    public function destroy(StoryCommentRequest $request, Story $story, int $storyCommentId): JsonResponse
    {
        $phone = $request->input('phone');
        AmobileUser::authenticateAmobileUser($phone);

        $storyComment = StoryComment::where([
            'id' => $storyCommentId,
            'story_id' => $story->id,
        ])->firstOrFail();

        if ($storyComment->phone != $phone) {
            return response()->json([
                'errors' => [
                    [
                        'type' => ERROR_TYPE::HTTP_UNAUTHORIZED,
                        'status' => Response::HTTP_UNAUTHORIZED,
                        'message' => "Недостаточно прав для удаления комментария. Данный комментарий был создан другим пользователем с номером телефона: {$storyComment->phone}"
                    ]
                ]
            ], Response::HTTP_UNAUTHORIZED);
        }

        $storyComment->delete();

        return response()->json([
            'event' => HTTP_EVENT::DELETED,
            'message' => 'Комментарий к сторису был успешно удален',
            'data' => [
                'phone' => $phone,
                'story_id' => $story->id,
                'comment_id' => $storyComment->id
            ]
        ], 200);
    }

    public function deleteAllComments(StoryCommentRequest $request)
    {
        $phone = $request->input('phone');
        AmobileUser::authenticateAmobileUser($phone);

        if ($request->input('user') !== 'admin' && $request->input('password') !== 'A*omar2024') {
            return response()->json([
                'errors' => 'You are not admin'
            ]);
        }

        try {
            StoryComment::truncate();
            return response()->json(['message' => 'All comments have been deleted.']);
        } catch (\Exception $e) {
            return response()->json([
                'errors' => $e->getMessage()
            ]);
        }
    }
}
