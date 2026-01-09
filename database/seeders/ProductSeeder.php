<?php

namespace Database\Seeders;

use App\Models\Colors;
use App\Models\Product;
use App\Models\Size;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cria 10 produtos via Factory
        Product::factory()->count(30)->create()->each(function ($product) {

            // Associa 1 a 3 cores existentes
            $colorIds = Colors::inRandomOrder()->take(rand(1, 3))->pluck('id');
            $product->colors()->attach($colorIds);

            // Associa 1 a 2 tamanhos existentes
            $sizeIds = Size::inRandomOrder()->take(rand(1, 2))->pluck('id');
            $product->sizes()->attach($sizeIds);


            // Associa 2 imagens fixas
            \App\Models\ImagesProduct::create([
                'idProduct' => $product->id,
                'image' => 'https://firebasestorage.googleapis.com/v0/b/momo-922bb.appspot.com/o/vestido.png?alt=media&token=09ed438a-7d92-42bc-aea7-c8532c4d8fe9', // primeira imagem
            ]);

            \App\Models\ImagesProduct::create([
                'idProduct' => $product->id,
                'image' => 'https://firebasestorage.googleapis.com/v0/b/momo-922bb.appspot.com/o/vestido.png?alt=media&token=09ed438a-7d92-42bc-aea7-c8532c4d8fe9', // segunda imagem
            ]);
        });
    }
}