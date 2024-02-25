<?php

namespace App\Enums;

enum OrderStatus {
    case Received;
    case Sent;
    case Refused;
    case Preparing;
}