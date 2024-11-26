<?php

namespace App\Actions\Books\Electronic;

use App\Models\V1\Books\ElectronicFormat;

class GetElectronicFormatsAction
{
    public function execute(int $perPage = null)
    {
        $query = ElectronicFormat::query();
        return $perPage ? $query->paginate($perPage) : $query->get(); 
    }
}