<?php

namespace App\Services;

class ImageService
{
    public function storeImages($files, $model)
    {
        foreach ($files as $file) {
            $path = $file->store('images/cars','public');
            $model->images()->create([
                'path' => $path,
                'alt' => 'Selling Request Car Image',
            ]);
        }
    }
}
