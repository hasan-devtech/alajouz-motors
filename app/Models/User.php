<?php

namespace App\Models;

use App\Enums\UserStatusEnum;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements FilamentUser
{
    use
        HasFactory,
        Notifiable,
        HasApiTokens,
        SoftDeletes;

    public function canAccessPanel(Panel $panel): bool
    {
        // TODO: make it only for some roles
        return true;
    }

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'hired_date',
        'salary',
        'status',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'hired_date' => 'datetime',
            'salary' => 'integer',
            'password' => 'hashed',
        ];
    }
    public function canLogin()
    {
        return $this->status === UserStatusEnum::Active;
    }
}
