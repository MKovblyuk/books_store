<?php

namespace App\Helpers;

class FileNameGenerator 
{
    public function generate($id, string $name = '_'): string
    {
        return $id . '_' . $name . '_' . rand(0, 1000) . '_' . time();
    }
}