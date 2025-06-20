<?php

namespace App\Models;

use App\Enums\OTPTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OTP extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'request_code',
        'phone',
        'type',
    ];

    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'code' => 'hashed',
            'request_code' => 'hashed',
            'type' => OTPTypeEnum::class,
        ];
    }
}
