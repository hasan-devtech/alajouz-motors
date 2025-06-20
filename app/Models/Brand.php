<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
    ];

    protected function casts(): array
    {
        return [
            'id' => 'integer',
        ];
    }

    public function brandModels(): HasMany
    {
        return $this->hasMany(BrandModel::class);
    }

    public function cars(): HasMany
    {
        return $this->hasMany(Car::class);
    }

    public function sellingRequests(): HasMany
    {
        return $this->hasMany(SellingRequest::class);
    }

    public function image(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}
