<?php

namespace App\Http\Requests\Logradouro;

use Illuminate\Foundation\Http\FormRequest;

class StoreLogradouroRequest extends FormRequest
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
            'street'   => 'required|string',
            'zip_code' => 'required|string',
            'district' => 'required|string',
            'city'     => 'required|string',
            'state'    => 'required|string',
            'number'   => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'street.required'   => 'O campo rua é obrigatório.',
            'street.string'     => 'O campo rua deve ser um texto válido.',

            // CEP
            'zip_code.required' => 'O CEP é obrigatório.',
            'zip_code.string'   => 'O CEP deve ser um texto válido.',

            // Bairro
            'district.required' => 'O bairro é obrigatório.',
            'district.string'   => 'O bairro deve ser um texto válido.',

            // Cidade
            'city.required'     => 'A cidade é obrigatória.',
            'city.string'       => 'A cidade deve ser um texto válido.',

            // Estado
            'state.required'    => 'O estado é obrigatório.',
            'state.string'      => 'O estado deve ser um texto válido.',

            // Número
            'number.required'   => 'O número é obrigatório.',
            'number.string'     => 'O número deve ser um texto válido.',
        ];
    }
}