<?php

namespace App\Models;

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
        ];
    }
}
