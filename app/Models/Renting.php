<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Renting extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'customer_id',
        'car_id',
        'start_date',
        'end_date',
        'total_price',
        'status',
        'license',
    ];

    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'customer_id' => 'integer',
            'car_id' => 'integer',
            'start_date' => 'timestamp',
            'end_date' => 'timestamp',
            'total_price' => 'decimal:2',
        ];
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class);
    }
}
