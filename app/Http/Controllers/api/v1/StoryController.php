<?php

namespace App\Http\Controllers\api\v1;

use App\Enums\api\v1\HTTP_EVENT;
use App\Http\Filters\v1\StoryFilter;
use App\Http\Requests\v1\StoryRequest;
use App\Http\Resources\v1\StoryResource;
use App\Models\AmobileUser;
use App\Models\Story;
use App\Models\StoryLike;
use App\Models\StoryView;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class StoryController extends ApiController
{
    public function index(StoryRequest $request, StoryFilter $filters): AnonymousResourceCollection
    {
        AmobileUser::authenticateAmobileUser($request->input('phone'));

        return StoryResource::collection(Story::filter($filters)->get());
    }

    public function show(StoryRequest $request, Story $story): StoryResource
    {
        AmobileUser::authenticateAmobileUser($request->input('phone'));

        $story->load($this->validRelationships(Story::$relationships));

        return new StoryResource($story);
    }

    public function watchStory(Request $request, Story $story): JsonResponse
    {
        $amobile_user = AmobileUser::authenticateAmobileUser($request->input('phone'));

        $storyView = StoryView::where([
            'story_id' => $story->id,
            'amobile_user_id' => $amobile_user->id,
        ])->first();

        if ($storyView) {
            return response()->json([
                'event' => HTTP_EVENT::UNCHANGED,
                'message' => 'Сторис уже был просмотрен данным пользователем',
                'data' => [
                    'phone' => $amobile_user->phone,
                    'story_id' => $story->id
                ]
            ]);
        }

        StoryView::create([
            'story_id' => $story->id,
            'amobile_user_id' => $amobile_user->id,
        ]);

        return response()->json([
            'event' => HTTP_EVENT::CREATED,
            'message' => 'Просмотр сториса был успешно зафиксирован',
            'data' => [
                'phone' => $amobile_user->phone,
                'story_id' => $story->id
            ],
        ], 201);
    }

    public function likeStory(StoryRequest $request, Story $story): JsonResponse
    {
        $amobile_user = AmobileUser::authenticateAmobileUser($request->input('phone'));

        $story_like = StoryLike::where([
            'story_id' => $story->id,
            'amobile_user_id' => $amobile_user->id,
        ])->first();

        if ($story_like) {
            $story_like->delete();
            return response()->json([
                'event' => HTTP_EVENT::DELETED,
                'message' => 'Лайк был успешно удален',
                'data' => [
                    'phone' => $amobile_user->phone,
                    'story_id' => $story->id
                ],
            ], 200);
        }

        StoryLike::create([
            'story_id' => $story->id,
            'amobile_user_id' => $amobile_user->id,
        ]);

        return response()->json([
            'event' => HTTP_EVENT::CREATED,
            'message' => 'Лайк был успешно создан',
            'data' => [
                'phone' => $amobile_user->phone,
                'story_id' => $story->id
            ],
        ], 201);
    }
}