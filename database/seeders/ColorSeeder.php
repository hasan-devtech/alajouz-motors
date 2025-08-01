<?php

namespace Database\Seeders;

use App\Models\Color;
use Illuminate\Database\Seeder;

class ColorSeeder extends Seeder {
    public function run(): void
    {
        $colors = [
            'Red',
            'Black',
            'White',
            'Gray',
            'Blue',
            'Silver',
            'Green',
            'Yellow',
            'Orange',
            'Brown',
            'Gold',
            'Beige'
        ];
        foreach($colors as $color){
            Color::create([
                'name' => $color
            ]);
        }
    }
}
