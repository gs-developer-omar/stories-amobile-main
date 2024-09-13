<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;

abstract class BaseStoriesRequest extends FormRequest
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
            'phone' => [
                'required',
                'string',
                'min:7',
                'max:32',
                'regex:/^[\+\d\- \(\)]+$/'
            ],
        ];
    }
}
