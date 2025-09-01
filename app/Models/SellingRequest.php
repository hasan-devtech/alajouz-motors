<?php

namespace App\Models;

use App\Enums\RequestStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class SellingRequest extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'car_id',
        'customer_id',
        'price',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'customer_id' => 'integer',
            'car_id' => 'integer',
            'price' => 'decimal:2',
            'status' => RequestStatusEnum::class,
        ];
    }
    public function isPending()
    {
        return $this->status === RequestStatusEnum::Pending;
    }
    public function isCancelled()
    {
        return $this->status === RequestStatusEnum::Cancelled;
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function car()
    {
        return $this->belongsTo(Car::class);
    }

}
