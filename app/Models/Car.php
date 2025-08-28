<?php

namespace App\Models;

use App\Enums\CarEngineTypeEnum;
use App\Enums\CarStatusEnum;
use App\Enums\CarListingTypeEnum;
use App\Enums\RequestStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class Car extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'brand_id',
        'brand_model_id',
        'car_type_id',
        'color_id',
        'year',
        'distance',
        'engine',
        'engine_type',
        'price',
        'vin',
        'mood',
        'status',
    ];

    protected $casts = [
        'id' => 'integer',
        'brand_id' => 'integer',
        'brand_model_id' => 'integer',
        'car_type_id' => 'integer',
        'color_id' => 'integer',
        'year' => 'integer',
        'distance' => 'decimal:2',
        'price' => 'decimal:2',
        'engine_type' => CarEngineTypeEnum::class,
        'mood' => CarListingTypeEnum::class,
        'status' => CarStatusEnum::class,
    ];

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
    public function CarType()
    {
        return $this->belongsTo(CarType::class);
    }
    public function rentings()
    {
        return $this->hasMany(Renting::class);
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
            ->when($filters['status'] ?? null, function ($q, $v) {
                if (is_array($v)) {
                    $q->whereIn('status', $v);
                } else {
                    $q->where('status', $v);
                }
            })
            ->when($filters['car_type_id'] ?? null, fn($q, $v) => $q->where('car_type_id', $v));
    }
    public function isRentOrAvailable()
    {
        return in_array($this->status, [
            CarStatusEnum::Available,
            CarStatusEnum::Rented,
        ]);
    }
    public function isAvailableForRent()
    {
        return $this->mood === CarListingTypeEnum::Rent;
    }

    public function isAvailableForPeriod($startDate, $endDate)
    {
        return !$this->rentings()
            ->where('status', 'approved')
            ->where(function ($query) use ($startDate, $endDate) {
                $query->whereBetween('start_date', [$startDate, $endDate])
                    ->orWhereBetween('end_date', [$startDate, $endDate])
                    ->orWhere(function ($q) use ($startDate, $endDate) {
                        $q->where('start_date', '<=', $startDate)
                            ->where('end_date', '>=', $endDate);
                    });
            })
            ->exists();
    }
    public function approvedRentings()
    {
        return $this->hasMany(Renting::class)
            ->where('status', RequestStatusEnum::Approved);
    }


    public function getAvailabilityScheduleAttribute()
    {
        $now = Carbon::now(setting('timezone'));
        $rentings = $this->relationLoaded('approvedRentings')
            ? $this->approvedRentings->where('end_date', '>=', $now)->sortBy('start_date')
            : $this->approvedRentings()->where('end_date', '>=', $now)->orderBy('start_date')->get();
        $schedule = [];
        $lastPointer = $now;
        foreach ($rentings as $renting) {
            if ($lastPointer < $renting->start_date) {
                $schedule[] = [
                    'status' => 'Available',
                    'start_date' => $lastPointer->toDateString(),
                    'end_date' => $renting->start_date->toDateString(),
                ];
            }
            $rStart = $renting->start_date->lt($now) ? $now : $renting->start_date;
            $schedule[] = [
                'status' => 'Rented',
                'start_date' => $rStart->toDateString(),
                'end_date' => $renting->end_date->toDateString(),
            ];
            $lastPointer = $renting->end_date;
        }
        $schedule[] = [
            'status' => 'Available',
            'start_date' => $lastPointer->toDateString(),
            'end_date' => null,
        ];
        return $schedule;
    }
}
