<?php

namespace App\Http\Requests\v1;

use App\Models\StoryComment;
use App\Rules\ExcludeRepliesAndParentComment;
use App\Rules\RelationshipsRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoryCommentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'include' => [
                'string',
                new RelationshipsRule(StoryComment::$relationships),
                new ExcludeRepliesAndParentComment(StoryComment::$relationships),
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
    }
}
