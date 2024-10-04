<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoryItemRequest extends FormRequest
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
                Rule::in(['storyItemButtons'])
            ],
            'sort' => [
                'string',
                Rule::in(['position', '-position', 'title', '-title'])
            ],
            'id' => [
                'integer',
                'min:0',
                'max:10000',
            ],
            'is_published' => [
                'string',
                Rule::in(['true', 'false'])
            ]
        ];
    }
}
