<?php

namespace App\Models\Books;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Fragment extends Model
{
    use HasFactory;

    protected $fillable = [
        'url',
        'book_id',
    ];

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }
}
