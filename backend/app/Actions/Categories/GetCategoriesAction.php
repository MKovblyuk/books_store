<?php

namespace App\Actions\Categories;

use App\Models\V1\Books\Category;
use Illuminate\Support\Collection;

class GetCategoriesAction
{
    public function execute(): Collection
    {
        return Category::get()->toTree()[0]->children;
    }
}