<?php

namespace App\Http\Requests\Logradouro;

use Illuminate\Foundation\Http\FormRequest;

class CheckZipCodeRequest extends FormRequest
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
            'zipCode' => 'required|string'
        ];
    }

    public function messages(): array
    {
        return [
            'zipCode.required' => 'O CEP é obrigatório',
            'zipCode.string' => 'O CEP deve ser uma string'
        ];
    }
        
}