<?php

namespace App\Actions\Books\Audio;

use App\Models\V1\Books\AudioFormat;

class GetAudioFormatsAction
{
    public function execute(int $perPage = null)
    {
        $query = AudioFormat::query();
        return $perPage ? $query->paginate($perPage) : $query->get(); 
    }
}