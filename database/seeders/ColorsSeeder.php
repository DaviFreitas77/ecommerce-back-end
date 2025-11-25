<?php

namespace Database\Seeders;

use App\Models\Colors;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ColorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $colors = ['blue', 'black', 'pink', 'yellow', 'red', 'white', 'green', 'purple', 'orange'];
        foreach ($colors as $color) {
            Colors::create([
                'name' => $color
            ]);
        }
    }
}
