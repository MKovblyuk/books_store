<?php

namespace App\Actions\Books\Audio;

use App\Models\V1\Books\AudioFormat;
use Illuminate\Support\Facades\DB;

class DeleteAudioFormatAction
{
    public function execute(AudioFormat $audioFormat): bool
    {
        return DB::transaction(function() use($audioFormat){
            return $audioFormat->delete() && $audioFormat->getFileStorageSerivce()->delete();
        });
    }
}