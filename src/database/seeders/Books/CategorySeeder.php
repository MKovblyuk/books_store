<?php

namespace Database\Seeders\Books;

use App\Models\Books\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Category::create([
            'name' => 'root_category',
            'children' => [
                [
                    'name' => 'science and technology',
                    'children' => [
                        [
                            'name' => 'astronomy, space',
                            'children' => [
                                [ 
                                    'name' => 'theoretical astronomy' 
                                ],
                                [ 
                                    'name' => 'stellar astronomy' 
                                ],
                                [ 
                                    'name' => 'celestial mechanics' 
                                ],
                            ],
                        ],
                        [
                            'name' => 'biological sciences',
                            'children' => [
                                [ 
                                    'name' => 'general genetics' 
                                ],
                                [ 
                                    'name' => 'microbiology. virology' 
                                ],
                            ],
                        ],
                        [
                            'name' => 'chemistry',
                            'children' => [
                                [ 
                                    'name' => 'inorganic chemistry' 
                                ],
                                [ 
                                    'name' => 'organic chemistry' 
                                ],
                            ],
                        ],
                    ],
                ],
                [
                    'name' => 'history',
                    'children' => [
                        [
                            'name' => 'military history',
                        ],
                        [
                            'name' => 'world history',
                        ],
                    ],
                ],
            ]
        ]);
    }
}
