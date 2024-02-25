<?php

namespace Database\Seeders\Books;

use App\Models\Books\Fragment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FragmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Fragment::factory(20)->create();
    }
}
