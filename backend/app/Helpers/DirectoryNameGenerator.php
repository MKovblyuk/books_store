<?php

namespace App\Helpers;

class DirectoryNameGenerator
{
    public function generate(int $id, string $name): string
    {
        return $id . '_' . strtolower(str_replace(' ', '_', $name));
    }
}