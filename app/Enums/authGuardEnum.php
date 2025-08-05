<?php
namespace App\Enums;

enum authGuardEnum: string
{
    case User = 'user-api';
    case Customer = 'customer-api';
}