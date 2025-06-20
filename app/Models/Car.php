<?php

namespace App\Models;

use App\Enums\CarEngineTypeEnum;
use App\Enums\CarStatusEnum;
use App\Enums\CarTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Car extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'brand_id',
        'brand_model_id',
        'color_id',
        'year',
        'distance',
        'engine',
        'engine_type',
        'price',
        'vin',
        'type',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'brand_id' => 'integer',
            'brand_model_id' => 'integer',
            'color_id' => 'integer',
            'year' => 'integer',
            'distance' => 'decimal:2',
            'price' => 'decimal:2',
            'engine_type' => CarEngineTypeEnum::class,
            'type' => CarTypeEnum::class,
            'status' => CarStatusEnum::class,
        ];
    }

    public function favorites(): BelongsToMany
    {
        return $this->belongsToMany(Customer::class, 'favorites');
    }

    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function brandModel(): BelongsTo
    {
        return $this->belongsTo(BrandModel::class);
    }

    public function color(): BelongsTo
    {
        return $this->belongsTo(Color::class);
    }
}
