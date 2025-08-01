<?php

namespace App\Services;

use App\Models\Color;

class ColorService
{
    public function getColors(){
        return Color::select('id','name')->get();
    }
}
