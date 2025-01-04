<?php

namespace App\Helpers;

class FileNameGenerator 
{
    public function generate($id, string $name = '_'): string
    {
        return $id . '_' . $name . '_' . uuid_create();
    }
}