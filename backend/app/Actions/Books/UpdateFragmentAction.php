<?php

namespace App\Actions\Books;

use App\Models\V1\Books\Fragment;
use Illuminate\Support\Facades\Storage;

class UpdateFragmentAction
{
    public function execute(Fragment $fragment, $attributes)
    {
        if ($attributes['file']) {
            Storage::disk('preview_fragments')->delete($fragment->path);
            Storage::disk('preview_fragments')->put($fragment->path, $attributes['file']->get());
        }

        $fragment->update($attributes);
    }
}