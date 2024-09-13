<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Filters\v1\StoryFilter;
use App\Http\Requests\v1\StoryRequest;
use App\Http\Resources\v1\StoryResource;
use App\Models\AmobileUser;
use App\Models\Story;
use App\Models\StoryLike;
use App\Models\StoryView;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class StoriesController extends ApiController
{
    public function index(StoryRequest $request, StoryFilter $filters): AnonymousResourceCollection
    {
        $phone = $request->input('phone');

        AmobileUser::firstOrCreate([
            'phone' => $phone,
        ]);

        return StoryResource::collection(Story::filter($filters)->get());
    }

    public function show(StoryRequest $request, Story $story): StoryResource
    {
        $phone = $request->input('phone');

        AmobileUser::firstOrCreate([
            'phone' => $phone,
        ]);

        if ($this->include('storyItems')) {
            return new StoryResource($story->load('storyItems'));
        }
        if ($this->include('storyItems.storyItemButtons')) {
            return new StoryResource($story->load('storyItems.storyItemButtons'));
        }

        return new StoryResource($story);
    }

    public function watchStory(StoryRequest $request, Story $story): JsonResponse
    {
        $phone = $request->input('phone');
        $amobile_user = AmobileUser::firstOrCreate([
            'phone' => $phone,
        ]);
        StoryView::updateOrCreate([
            'story_id' => $story->id,
            'amobile_user_id' => $amobile_user->id,
        ]);

        return json([
            'message' => 'Просмотр сториса был успешно зафиксирован.',
            'phone' => $amobile_user->phone,
            'story' => new StoryResource($story)
        ], 201);
    }

    public function likeStory(StoryRequest $request, Story $story): JsonResponse
    {
        $phone = $request->input('phone');
        $amobile_user = AmobileUser::firstOrCreate([
            'phone' => $phone,
        ]);
        $story_like = StoryLike::where('story_id', $story->id)->where('amobile_user_id', $amobile_user->id)->first();

        if ($story_like) {
            $story_like->delete();
            return json([
                'message' => 'Лайк был успешно удален.',
                'event' => 'deleted',
                'phone' => $amobile_user->phone,
                'story' => new StoryResource($story)
            ], 200);
        }

        StoryLike::create([
            'story_id' => $story->id,
            'amobile_user_id' => $amobile_user->id,
        ]);

        return json([
            'message' => 'Лайк был успешно создан.',
            'event' => 'created',
            'phone' => $amobile_user->phone,
            'story' => new StoryResource($story)
        ], 201);
    }
}