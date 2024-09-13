<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StoryItemButtonResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $storage_path = config('app.url') . '/storage/';
        return [
            'id' => $this->id,
            'button_text' => $this->button_text,
            'media_url' => $storage_path . $this->media_url,
            'position' => $this->position,
            'is_active' => $this->is_active,
        ];
    }
}
