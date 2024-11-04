<?php

namespace App\Enums;

use App\Traits\InteractingWithEnums;

enum PaymentMethods : string 
{
    use InteractingWithEnums;

    case UponReceiving = 'UponReceiving';
    case CreditCard = 'CC';
}