<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStoryCommentRequest extends BaseStoriesRequest
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
            'content' => 'required|string|min:1|max:2048',
        ];
        return array_merge($parent_rules, $child_rules);
    }
}
