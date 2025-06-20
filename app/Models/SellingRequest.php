<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class SellingRequest extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'brand_id',
        'brand_model_id',
        'customer_id',
        'color_id',
        'year',
        'distance',
        'engine',
        'engine_type',
        'price',
        'price_after_commission',
        'vin',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'brand_id' => 'integer',
            'brand_model_id' => 'integer',
            'customer_id' => 'integer',
            'color_id' => 'integer',
            'year' => 'timestamp',
            'distance' => 'decimal:2',
            'price' => 'decimal:2',
            'price_after_commission' => 'decimal:2',
        ];
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

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function color(): BelongsTo
    {
        return $this->belongsTo(Color::class);
    }
}
