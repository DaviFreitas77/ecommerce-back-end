<?php

namespace App\Http\Requests\Color;

use Illuminate\Foundation\Http\FormRequest;

class StoreColorRequest extends FormRequest
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
            'name' => 'required|string|max:255|unique:colors,name',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O nome da cor é obrigatório.',
            'name.string' => 'O nome da cor deve ser uma string.',
            'name.max' => 'O nome da cor não pode exceder 255 caracteres.',
            'name.unique' => 'O nome da cor já existe.',
        ];
    }
}