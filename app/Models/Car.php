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
    public function scopeFilter($query, array $filters)
    {
        return $query
            ->when($filters['brand_id'] ?? null, fn($q, $v) => $q->where('brand_id', $v))
            ->when($filters['brand_model_id'] ?? null, fn($q, $v) => $q->where('brand_model_id', $v))
            ->when($filters['color_id'] ?? null, fn($q, $v) => $q->where('color_id', $v))
            ->when($filters['year'] ?? null, fn($q, $v) => $q->where('year', $v))
            ->when($filters['min_price'] ?? null, fn($q, $v) => $q->where('price', '>=', $v))
            ->when($filters['max_price'] ?? null, fn($q, $v) => $q->where('price', '<=', $v))
            ->when($filters['engine'] ?? null, fn($q, $v) => $q->where('engine', $v))
            ->when($filters['engine_type'] ?? null, fn($q, $v) => $q->where('engine_type', $v))
            ->when($filters['status'] ?? null, fn($q, $v) => $q->where('status', $v))
            ->when($filters['car_type'] ?? null, fn($q, $v) => $q->where('type', $v));
    }
}
