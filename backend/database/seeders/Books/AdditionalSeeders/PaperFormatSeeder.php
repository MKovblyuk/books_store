<?php

namespace Database\Seeders\Books\AdditionalSeeders;

use App\Models\V1\Books\PaperFormat;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class PaperFormatSeeder
{
    /**
     * Seed Paper Format for Book
     */
    public static function seed(Collection $books): void
    {
        $data = [];
        
        foreach ($books as $book) {
            $data[] = PaperFormat::factory()->for($book)->make()->toArray();
        }

        DB::table('paper_formats')->insert($data);
    }
}