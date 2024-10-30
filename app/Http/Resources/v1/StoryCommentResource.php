<?php

namespace App\Http\Resources\v1;

use App\Models\StoryComment;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

class StoryCommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $replies = $this->whenLoaded('replies');
        if ($replies instanceof Collection) {
            $replies = $replies->sortByDesc('updated_at');
        }

        $emojiCounts = $this->whenLoaded('emojis', function () {
            return $this->emojis->groupBy('emoji')->map(function ($group) {
                return [
                    'emoji' => $group->first()->emoji,
                    'count' => $group->count(),
                ];
            })->values();
        });

        return [
            'id' => $this->id,
            'story_id' => $this->story_id,
            'phone' => $this->phone,
            'is_marked' => $this->isMarkedByAmobileUser(),
            'content' => $this->content,
            'updated_at' => $this->updated_at->setTimezone('Europe/Moscow')->format('H:i:s d-m-Y'),
            'parent_id' => $this->parent_id,
            'parent_comment' => new StoryCommentResource($this->whenLoaded('parentComment')),
            'replies' => StoryCommentResource::collection($replies),
            'emojis' => $emojiCounts,
        ];
    }
}
