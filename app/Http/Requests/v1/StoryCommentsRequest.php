<?php

namespace App\Http\Requests\v1;

use App\Models\StoryComment;
use App\Rules\RelationshipsRule;
use Illuminate\Validation\Rule;

class StoryCommentsRequest extends BaseStoriesRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return parent::authorize();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $parent_rules = parent::rules();
        $child_rules = [
            'include' => [
                'string',
                new RelationshipsRule(StoryComment::$relationships)
            ],
            'sort' => [
                'string',
                Rule::in(['updated_at', '-updated_at'])
            ],
            'id' => [
                'integer',
                'min:0',
                'max:10000',
            ],
            'story_id' => [
                'integer',
                'min:0',
                'max:10000',
            ],
            'parent_id' => [
                'integer',
                'min:0',
                'max:10000',
            ],
        ];
        return array_merge($parent_rules, $child_rules);
    }
}
