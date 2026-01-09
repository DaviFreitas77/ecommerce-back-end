<?php

namespace App\Http\Requests\auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            "email" => 'required|string|email',
            "password" => 'required|string',
        ];
    }


     public function messages(): array
    {
        return [
            "email.required" => "o email é obrigatório",
            "email.email" => "o email deve ser um email válido",
            "email.string" => "o email deve ser uma string",

            "password.required" => "a senha é obrigatório",
            "password.string" => "a senha deve ser uma string",
            
         
       
        ];
    }
}