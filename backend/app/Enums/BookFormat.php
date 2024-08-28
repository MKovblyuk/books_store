<?php

namespace App\Enums;

use App\Traits\InteractingWithEnums;

enum BookFormat : string 
{
    use InteractingWithEnums;
    
    case Audio = 'Audio';
    case Electronic = 'Electronic';
    case Paper = 'Paper';
}