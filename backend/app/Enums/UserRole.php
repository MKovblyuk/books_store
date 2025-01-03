<?php

namespace App\Enums;

enum UserRole : string 
{
    case Admin = 'Admin';
    case Editor = 'Editor';
    case Customer = 'Customer';
    case Guest = 'Guest';
}