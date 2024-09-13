<?php

namespace App\Http\Resources\v1;

use App\Models\StoryItemButton;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StoryItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $storage_path = config('app.url') . '/storage/';

        $storyItemButtons = $this->whenLoaded('storyItemButtons');
        if ($storyItemButtons instanceof Collection) {
            $storyItemButtons = StoryItemButtonResource::collection($storyItemButtons->sortBy('position')->where('is_active', 1));
        }
        return [
            'id' => $this->id,
            'title' => $this->name,
            'file_path' => $storage_path . $this->file_path,
            'position' => $this->position,
            'is_published' => $this->is_published,
            'storyItemButtons' => $storyItemButtons,
        ];
    }
}
