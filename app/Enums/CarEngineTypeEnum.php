<?php

namespace App\Enums;

enum CarEngineTypeEnum: string
{
    case Petrol = 'petrol';
    case Diesel = 'diesel';
    case Electric = 'electric';
    case Hybrid = 'hybrid';
}
