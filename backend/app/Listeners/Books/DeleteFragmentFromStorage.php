<?php

namespace App\Listeners\Books;

use App\Models\V1\Books\Fragment;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Storage;

class DeleteFragmentFromStorage implements ShouldHandleEventsAfterCommit
{
    public function __construct()
    {
        //
    }

    public function handle(object $event): void
    {
        Storage::disk('preview_fragments')->delete($event->fragment->path);
    }
}
