<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Size;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
         return [
            'name' => $this->faker->word(),               // Nome do produto
            'description' => $this->faker->sentence(),    // Descrição aleatória
            'price' => $this->faker->randomFloat(2, 10, 200), // Preço entre 10 e 200
            'lastPrice' => $this->faker->randomFloat(2, 50, 300), // Último preço
            'fkCategory' => \App\Models\Category::inRandomOrder()->first()->id ?? null, // Categoria aleatória existente

            'fkSubcategory' => \App\Models\SubCategory::inRandomOrder()->first()->id , // Subcategoria aleatória existente
        ];
    }
}