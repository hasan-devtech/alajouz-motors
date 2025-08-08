<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ImageService
{
    public function storeImages($files, $model)
    {
        foreach ($files as $file) {
            try {
                $path = $file->store('images/cars', 'public');
                $model->images()->create([
                    'path' => $path,
                    'alt' => 'Selling Request Car Image',
                ]);
            } catch (\Throwable $e) {
                Log::error('Failed to store image', [
                    'file' => $file->getClientOriginalName(),
                    'error' => $e->getMessage()
                ]);
            }
        }
    }

    public function deleteModelImages($model)
    {
        foreach ($model->images as $image) {
            try {
                Storage::disk('public')->delete($image->path);
                $image->delete();
            } catch (\Throwable $e) {
                Log::error('Failed to delete image', [
                    'path' => $image->path,
                    'error' => $e->getMessage()
                ]);
            }
        }
    }

}
