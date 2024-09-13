<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Filters\v1\StoryItemFilter;
use App\Http\Requests\v1\StoryItemRequest;
use App\Http\Resources\v1\StoryItemResource;
use App\Models\AmobileUser;
use App\Models\Story;
use App\Models\StoryItem;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class StoryStoryItemsController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index(StoryItemRequest $request, Story $story, StoryItemFilter $filters): AnonymousResourceCollection
    {
        $phone = $request->input('phone');

        AmobileUser::firstOrCreate([
            'phone' => $phone,
        ]);

        return StoryItemResource::collection(StoryItem::where('story_id', $story->id)->filter($filters)->get());
    }

    public function show(StoryItemRequest $request, Story $story, string $storyItemId): StoryItemResource
    {
        $phone = $request->input('phone');

        AmobileUser::firstOrCreate([
            'phone' => $phone,
        ]);

        $storyItem = StoryItem::where('story_id', $story->id)->where('id', $storyItemId)->firstOrFail();

        if ($this->include('storyItemButtons')) {
            return new StoryItemResource($storyItem->load('storyItemButtons'));
        }

        return new StoryItemResource($storyItem);
    }
}
