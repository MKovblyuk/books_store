<?php

namespace App\Models\V1\Books;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ElectronicFormat extends Model
{
    use HasFactory;

    protected $fillable = [
        'price',
        'discount',
        'page_count',
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
