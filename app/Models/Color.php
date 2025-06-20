<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Color extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    protected function casts(): array
    {
        return [
            'id' => 'integer',
        ];
    }

    public function cars(): HasMany
    {
        return $this->hasMany(Car::class);
    }

    public function sellingRequests(): HasMany
    {
        return $this->hasMany(SellingRequest::class);
    }
}
