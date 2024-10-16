<?php

namespace App\Models\V1\Books;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Events\Books\FragmentDeleted;

class Fragment extends Model
{
    use HasFactory;

    protected $fillable = [
        'path',
        'book_id',
    ];

    protected $dispatchesEvents = [
        'deleted' => FragmentDeleted::class,
    ];

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }
}
