<?php

namespace App\Enums;

enum RequestStatusEnum: string
{
    case Pending = 'pending';           
    case Approved = 'approved';         
    case Rejected = 'rejected';         
    case Cancelled = 'cancelled';       
    case Completed = 'completed';       
}

