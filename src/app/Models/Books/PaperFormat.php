<?php

namespace App\Models\Books;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PaperFormat extends Model
{
    use HasFactory;

    protected $fillable = [
        'price',
        'discount',
        'quantity',
        'page_count',
        'book_id',
    ];

    protected $casts = [
        'price' => 'decimal',
        'discount' => 'decimal',
    ];

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

}
