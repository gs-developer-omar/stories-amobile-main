<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Filters\v1\StoryItemButtonFilter;
use App\Http\Requests\v1\StoryItemButtonRequest;
use App\Http\Resources\v1\StoryItemButtonResource;
use App\Models\AmobileUser;
use App\Models\StoryItem;
use App\Models\StoryItemButton;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class StoryItemButtonController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index(StoryItemButtonRequest $request, StoryItem $storyItem, StoryItemButtonFilter $filters): AnonymousResourceCollection
    {
        AmobileUser::authenticateAmobileUser($request->input('phone'));

        return StoryItemButtonResource::collection(StoryItemButton::filter($filters)->where('story_item_id', $storyItem->id)->get());
    }
}
