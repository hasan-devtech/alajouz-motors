<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rate extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'car_id',
        'renting_id',
        'rate',
        'comment',
    ];

    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'customer_id' => 'integer',
            'car_id' => 'integer',
            'renting_id' => 'integer',
            'rate' => 'integer',
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

    public function renting(): BelongsTo
    {
        return $this->belongsTo(Renting::class);
    }
}
