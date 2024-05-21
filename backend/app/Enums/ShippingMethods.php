<?php

namespace App\Enums;

enum ShippingMethods : string
{
    case UponReceiving = 'Upon Receiving';
    case GooglePay = 'Google Pay';
}
