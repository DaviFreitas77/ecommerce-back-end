<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'required|string',
            'idCategory' => 'required|integer',
            'idSubcategory' => 'required|integer',
            'lastPrice' => 'nullable|numeric',
            'images' => 'required|array',
            'colors' => 'required|array',
            'sizes' => 'required|array',
        ];
    }

    public function messages():array
    {
        return[
            "name.required"=> "O nome é obrigatório",
            "name.string"=> "O nome deve ser uma string",
            "name.max"=> "O nome deve ter no máximo 255 caracteres",
            
            "price.required"=> "O preço é obrigatório",
            "price.numeric"=> "O preço deve ser um número",
            
            "lastPrice.numeric"=> "O preço anterior deve ser um número",
            
            "description.string"=> "A descrição deve ser uma string",
            "description.required"=> "A descrição é obrigatória",
            
            "idCategory.required"=> "A categoria é obrigatória",
            "idCategory.integer"=> "A categoria deve ser um número inteiro",

            "idSubcategory.required"=> "A subcategoria é obrigatória",
            "idSubcategory.integer"=> "A subcategoria deve ser um número inteiro",
            

            "images.required"=> "As imagens são obrigatórias",
            "colors.required"=> "As cores são obrigatórias",
            "sizes.required"=> "Os tamanhos são obrigatórios",
        ];
    }
}