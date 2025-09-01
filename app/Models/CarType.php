<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarType extends Model
{
    protected $fillable = ['name'];
    public function cars()
    {
        return $this->hasMany(Car::class);
    }
    public function sellingRequest()
    {
        return $this->hasMany(SellingRequest::class);
    }
}
