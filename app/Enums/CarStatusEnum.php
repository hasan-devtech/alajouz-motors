<?php

namespace App\Enums;

enum CarStatusEnum: string
{
    case Available = 'available';         
    case Rented = 'rented';                
    case Booked = 'booked';                 
    case Sold = 'sold';                    

}
