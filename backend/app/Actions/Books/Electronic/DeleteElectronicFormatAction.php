<?php

namespace App\Actions\Books\Electronic;

use App\Models\V1\Books\ElectronicFormat;
use Illuminate\Support\Facades\DB;

class DeleteElectronicFormatAction
{
    public function execute(ElectronicFormat $electronicFormat): bool
    {
        return DB::transaction(function() use($electronicFormat){
            return $electronicFormat->delete() && $electronicFormat->getFileStorageService()->delete();
        });
    }
}