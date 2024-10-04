<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoryItemButtonRequest extends FormRequest
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
    }
}
