<?php

namespace App\Http\Requests\Cupom;

use Illuminate\Foundation\Http\FormRequest;

class UseCupomRequest extends FormRequest
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
            'nameCupom' => 'required|string|exists:discount_cupoms,nameCupom',
            'order' => 'required|integer|exists:tb_order,id',
        ];
    }

    public function messages(): array
    {
        return [
            'nameCupom.required' => 'O nome do cupom é obrigatório.',
            'nameCupom.string' => 'O nome do cupom deve ser uma string.',
            'nameCupom.exists' => 'Cupom inválido.',
            'order.required' => 'O ID do pedido é obrigatório.',
            'order.integer' => 'O ID do pedido deve ser um número inteiro.',
            'order.exists' => 'Pedido inválido.',
        ];
    }
}