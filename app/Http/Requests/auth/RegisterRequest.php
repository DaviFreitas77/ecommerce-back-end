<?php

namespace App\Http\Requests\auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            "name" => 'required|string',
            "email" => 'required|string|unique:users,email',
            "password" => 'required|string|min:8|max:30',
            "lastName" => 'required|string',
            "tel" => 'required|string'
        ];
    }

    public function messages(): array
    {
        return [
            "name.required" => "o nome é obrigatório",
            "email.required" => "o email é obrigatório",
            "email.unique" => "email ja vinculado a uma conta!",
            "password.required" => "a senha é obrigatório",
            "password.min" => "a senha deve ter no mínimo 8 caracteres",
            "password.max" => "a senha deve ter no máximo 30 caracteres",
            "tel.required" => "o telefone é obrigatório",
            
        ];
    }
}