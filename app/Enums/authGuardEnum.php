<?php
namespace App\Enums;

enum AuthGuardEnum: string
{
    case User = 'user-api';
    case Customer = 'customer-api';
}