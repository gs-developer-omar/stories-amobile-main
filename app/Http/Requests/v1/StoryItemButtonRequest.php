<?php

namespace App\Http\Requests\v1;

use Illuminate\Validation\Rule;

class StoryItemButtonRequest extends BaseStoriesRequest
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
            'sort' => [
                'string',
                Rule::in(['position', '-position', 'title', '-title'])
            ],
            'id' => [
                'integer',
                'min:0',
                'max:10000',
            ],
            'is_active' => [
                'string',
                Rule::in(['true', 'false'])
            ]
        ];
        return array_merge($parent_rules, $child_rules);
    }
}
