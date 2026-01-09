<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
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
            'items' => 'required|array|min:1',
            'idLogradouro' => 'nullable|integer',
        ];
    }


    public function messages(): array
    {
        return [
            'items.required' => 'O campo items é obrigatório.',
            'items.array' => 'O campo items deve ser um array.',
            'items.min' => 'O campo items deve conter pelo menos um item.',
            'idLogradouro.integer' => 'O campo idLogradouro deve ser um número inteiro.',
            'idLogradouro.exists' => 'O idLogradouro fornecido não existe.',
        ];
    }
}