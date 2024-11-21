<?php

namespace App\Actions\Books;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class GetLanguagesAction
{
    public function execute(): Collection
    {
        return DB::table('books')
            ->select('language')
            ->distinct()
            ->get()
            ->map(fn($item) => $item->language);
    }
}