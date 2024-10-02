<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Filters\v1\StoryCommentFilter;
use App\Http\Requests\v1\StoreStoryCommentRequest;
use App\Http\Requests\v1\StoryCommentsRequest;
use App\Http\Requests\v1\UpdateStoryCommentRequest;
use App\Http\Resources\v1\StoryCommentResource;
use App\Models\AmobileUser;
use App\Models\Story;
use App\Models\StoryComment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class StoryStoryCommentsController extends ApiController
{
    public function index(StoryCommentsRequest $request, Story $story, StoryCommentFilter $filters): AnonymousResourceCollection
    {
        AmobileUser::authorizeAmobileUser($request->input('phone'));

        return StoryCommentResource::collection(StoryComment::filter($filters)->whereNull('parent_id')->where('story_id', $story->id)->get());
    }

    public function show(StoryCommentsRequest $request, Story $story, string $storyCommentId): StoryCommentResource
    {
        $phone = $request->input('phone');
        AmobileUser::authorizeAmobileUser($phone);

        $storyComment = StoryComment::where([
            'id' => $storyCommentId,
            'phone' => $phone,
            'story_id' => $story->id,
        ])->firstOrFail();

        $storyComment->load($this->loadedRelationships(StoryComment::$relationships));

        return new StoryCommentResource($storyComment);
    }

    public function store(StoreStoryCommentRequest $request, Story $story): StoryCommentResource
    {
        $phone = $request->input('phone');
        AmobileUser::authorizeAmobileUser($phone);

        $storyComment = StoryComment::create([
            'story_id' => $story->id,
            'phone' => $phone,
            'content' => $request->input('content'),
            'parent_id' => $request->input('parent_id') ?? null,
        ]);

        return new StoryCommentResource($storyComment);
    }

    public function update(UpdateStoryCommentRequest $request, Story $story, string $storyCommentId): StoryCommentResource
    {
        $phone = $request->input('phone');
        AmobileUser::authorizeAmobileUser($phone);

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

    public function destroy(StoryCommentsRequest $request, Story $story, string $storyCommentId): JsonResponse
    {
        $phone = $request->input('phone');
        AmobileUser::authorizeAmobileUser($phone);

        $storyComment = StoryComment::where([
            'id' => $storyCommentId,
            'story_id' => $story->id,
            'phone' => $phone,
        ])->firstOrFail();

        $storyComment->delete();

        return response()->json([
            'message' => 'Комментарий к сторису был успешно удален.'
        ], 200);
    }
}
