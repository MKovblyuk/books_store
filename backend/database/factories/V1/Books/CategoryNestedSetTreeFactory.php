<?php

namespace Database\Factories\V1\Books;

use Illuminate\Support\Facades\Storage;

class CategoryNestedSetTreeFactory
{
    /**
     * @return array Categories nested set tree
     */
    public static function create(): array
    {
        return json_decode(Storage::disk('public')->get('seeding_files/json_files/categories.json'), true);
    }
}