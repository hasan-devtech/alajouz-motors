<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'device_id',
        'ip',
        'latitude',
        'longitude',
        'checked_in',
        'checked_out'

    ];

    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'user_id' => 'integer',
            'checked_in' => 'datetime',
            'checked_out' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function getWorkHoursAttribute()
    {
        if ($this->checked_out) {
            return $this->checked_out->diffInHours($this->checked_in);
        }
        return null;
    }
}
