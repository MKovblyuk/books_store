<?php

namespace App\Enums;

enum OrderStatus : string 
{
    case Pending = 'Pending';
    case Received = 'Received';
    case Sent = 'Sent';
    case Refused = 'Refused';
    case Preparing = 'Preparing';
    case ReadyToSend = 'Ready To Send';
}