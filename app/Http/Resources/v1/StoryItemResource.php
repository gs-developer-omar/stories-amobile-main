<?php

namespace App\Http\Resources\v1;

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
            $storyItemButtons = $storyItemButtons
                ->sortBy('position')
                ->where('is_active', true);
        }

        return [
            'element_id' => $this->id,
            'title' => $this->name,
            'media_type' => $this->media_type,
            'link' => $this->when($this->media_type === 'link', $this->link),
            'file_path' => $this->when($this->media_type === 'media_file', $storage_path . $this->file_path),
            'position' => $this->position,
            'is_published' => $this->is_published,
            'question' => $this->when(!empty($this->question), $this->question),
            'storyItemButtons' => StoryItemButtonResource::collection($storyItemButtons),
        ];
    }
}
