<?php

namespace App\Actions\Books\Paper;

use App\Models\V1\Books\PaperFormat;

class GetPaperFormatsAction
{
    public function execute(int $perPage = null)
    {
        $query = PaperFormat::query();
        return $perPage ? $query->paginate($perPage) : $query->get(); 
    }
}