<?php

namespace App\Enums;

enum OTPTypeEnum: string
{
    case Register = 'register';
    case ResetPassword = 'reset_password';

}
