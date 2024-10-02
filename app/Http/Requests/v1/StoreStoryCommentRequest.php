<?php

namespace App\Http\Requests\v1;

class StoreStoryCommentRequest extends BaseStoriesRequest
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
            'content' => 'required|string',
            'parent_id' => 'nullable|integer|exists:story_comments,id',
        ];
        return array_merge($parent_rules, $child_rules);
    }

    public function messages(): array
    {
        $messages = parent::messages();
        $messages['parent_id.exists'] = 'Комментария с указанным :attribute не существует';
        return $messages;
    }
}
