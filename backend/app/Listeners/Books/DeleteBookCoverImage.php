<?php

namespace App\Listeners\Books;

use App\Actions\Books\DeleteBookCoverImageAction;
use App\Models\V1\Books\Fragment;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Storage;

class DeleteBookCoverImage implements ShouldHandleEventsAfterCommit
{
    private DeleteBookCoverImageAction $action;

    public function __construct(DeleteBookCoverImageAction $action)
    {
        $this->action = $action;
    }

    public function handle(object $event): void
    {
        $this->action->execute($event->book);
    }
}
