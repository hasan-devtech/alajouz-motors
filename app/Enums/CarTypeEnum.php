<?php

namespace App\Enums;

enum CarTypeEnum: string
{
    case Sedan = 'sedan';
    case Hatchback = 'hatchback';
    case SUV = 'suv';
    case Coupe = 'coupe';
    case Convertible = 'convertible';
    case Truck = 'truck';
    case Van = 'van';
}
