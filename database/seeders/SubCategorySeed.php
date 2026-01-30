<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubCategorySeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $subCategories = [
            'Camisetas' => [
                'Manga longa',
                'Manga curta',
                'Regata',
                'Polo',
            ],
            'Calças' => [
                'Jeans',
                'Cargo',
                'Tectel',
            ],
            'Acessórios' => [
                'Bonés',
                'Cintos',
            ],
            'Vestido' => [
                'Vestido longo',
                'Vestido curto',
            ],
            'Blusas' => [
                'Moletom',
                'Suéter',
            ],
        ];

        foreach ($subCategories as $categoryName => $subs) {
            $category = Category::where('name', $categoryName)->first();

            foreach ($subs as $sub){
                $subCategory = new SubCategory;
                $subCategory->name = $sub;
                $subCategory->id_category = $category->id;
                $subCategory->save();
            }
        }
    }
}