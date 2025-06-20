<?php

namespace App\Models;

use App\Enums\PaymentMethodEnum;
use App\Enums\RequestStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'method',
        'amount',
        'payment_date',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'amount' => 'decimal:2',
            'payment_date' => 'datetime',
            'method' => PaymentMethodEnum::class,
            'status' => RequestStatusEnum::class,
        ];
    }
}
