<?php

namespace App\Models\V1\Books;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AudioFormat extends Model
{
    use HasFactory;

    protected $fillable = [
        'price',
        'discount',
        'duration',
        'url',
        'book_id',

    ];

    protected $casts = [
        'price' => 'decimal:2',
        'discount' => 'decimal:2',
    ];

    protected $hidden = [
        'url',
    ];

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }
}
