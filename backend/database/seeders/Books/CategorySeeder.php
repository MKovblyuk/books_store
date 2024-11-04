<?php

namespace Database\Seeders\Books;

use App\Models\V1\Books\Category;
use Database\Factories\V1\Books\CategoryNestedSetTreeFactory;
use Illuminate\Database\Seeder;

//
//  Nested set works based on model's events, so if use WithoutModelEvents Trait
//  this won't work !
//

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create(CategoryNestedSetTreeFactory::create());
    }
}
