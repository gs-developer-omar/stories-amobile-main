<?php

namespace App\Http\Resources\v1;

use App\Models\StoryComment;
use App\Models\StoryItem;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $storage_path = config('app.url') . '/storage/';

        $storyItems = $this->whenLoaded('storyItems');
        if ($storyItems instanceof Collection) {
            $storyItems = $storyItems
                ->sortBy('position')
                ->where('is_published', true);
        }

        $comments = $this->whenLoaded('comments');
        if ($comments instanceof Collection) {
            $comments = $comments
                ->where('parent_id', null);
        }

        return [
            'id' => $this->id,
            'title' => $this->title,
            'icon_url' => $storage_path . $this->icon_url,
            'position' => $this->position,
            'is_published' => $this->is_published,
            'likes_count' => $this->likes_count,
            'views_count' => $this->views_count,
            'is_liked' => $this->isLikedByAmobileUser(),
            'storyItems' => StoryItemResource::collection($storyItems),
            'comments' => StoryCommentResource::collection($comments),
        ];
    }
}
