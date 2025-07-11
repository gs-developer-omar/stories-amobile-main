<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;

class StoreStoryCommentRequest extends FormRequest
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
            'content' => 'required|string',
            'parent_id' => 'nullable|integer|exists:story_comments,id',
        ];
    }

    public function messages(): array
    {
        $messages = parent::messages();
        $messages['parent_id.exists'] = 'Комментария с указанным :attribute не существует';
        return $messages;
    }
}
