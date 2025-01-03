<?php

namespace App\Actions\Categories;

use App\Models\V1\Books\Category;
use Illuminate\Support\Collection;

class GetFlatCategoriesAction
{
    public function execute(): Collection
    {
        return Category::whereNot('parent_id')->get();
    }
}