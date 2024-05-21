<?php

namespace App\Enums;

enum OrderStatus : string {
    case Received = 'Received';
    case Sent = 'Sent';
    case Refused = 'Refused';
    case Preparing = 'Preparing';
}