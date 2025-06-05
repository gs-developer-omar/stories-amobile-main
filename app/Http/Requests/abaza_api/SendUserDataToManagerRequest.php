<?php

namespace App\Http\Requests\abaza_api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class SendUserDataToManagerRequest extends FormRequest
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
            'fio' => [
                'required',
                'string',
                'min:5',
                'max:512',
            ],
            'phone' => [
                'required',
                'string',
                'regex:/^\+7\s?\(\d{3}\)\s?\d{3}-\d{2}-\d{2}$/',
            ],
            'address' => [
                'required',
                'string',
                'min:5',
                'max:1024',
            ],
        ];
    }
    public function messages(): array
    {
        return [
            'fio.regex' => 'ФИО должно состоять из трех слов, каждое с большой буквы.',
            'phone.regex' => 'Номер телефона должен начинаться с +7 и содержать 10 цифр.',
            'address.regex' => 'Адрес должен содержать от 5 до 255 символов (буквы, цифры, пробелы, запятые, точки, дефисы, слеши).',
        ];
    }
}
