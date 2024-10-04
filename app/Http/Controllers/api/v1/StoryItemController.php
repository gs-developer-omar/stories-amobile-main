<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Filters\v1\StoryItemFilter;
use App\Http\Requests\v1\StoryItemRequest;
use App\Http\Resources\v1\StoryItemResource;
use App\Models\AmobileUser;
use App\Models\Story;
use App\Models\StoryItem;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class StoryItemController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index(StoryItemRequest $request, Story $story, StoryItemFilter $filters): AnonymousResourceCollection
    {
        AmobileUser::authenticateAmobileUser($request->input('phone'));

        return StoryItemResource::collection(StoryItem::where('story_id', $story->id)->filter($filters)->get());
    }

    public function show(StoryItemRequest $request, Story $story, int $storyItemId): StoryItemResource
    {
        AmobileUser::authenticateAmobileUser($request->input('phone'));

        $storyItem = StoryItem::where([
            'id' => $storyItemId,
            'story_id' => $story->id,
        ])->firstOrFail();

        $storyItem->load($this->validRelationships(StoryItem::$relationships));

        return new StoryItemResource($storyItem);
    }
}
