<?php

namespace App\Http\Requests\Cupom;

use Illuminate\Foundation\Http\FormRequest;

class StoreCupomRequest extends FormRequest
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
            'nameCupom' => 'required|string|max:255',
            'discount' => 'required|numeric|min:0',
            'validity' => 'required|date',
            'limitUse' => 'required|integer|min:1',
        ];
    }

    public function messages(): array
    {
        return [
            'nameCupom.required' => 'O nome do cupom é obrigatório.',
            'nameCupom.string' => 'O nome do cupom deve ser uma string.',
            'nameCupom.max' => 'O nome do cupom não pode exceder 255 caracteres.',
            'discount.required' => 'O desconto é obrigatório.',
            'discount.numeric' => 'O desconto deve ser um número.',
            'discount.min' => 'O desconto não pode ser negativo.',
            'validity.required' => 'A validade é obrigatória.',
            'validity.date' => 'A validade deve ser uma data válida.',
            'limitUse.required' => 'O limite de uso é obrigatório.',
            'limitUse.integer' => 'O limite de uso deve ser um número inteiro.',
            'limitUse.min' => 'O limite de uso deve ser pelo menos 1.',
        ];
    }
}