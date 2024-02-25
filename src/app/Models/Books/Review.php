<?php

namespace App\Models\Books;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'rating',
        'review',
        'user_id',
        'book_id',
        'parent_review_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    public function parentReview(): BelongsTo
    {
        return $this->belongsTo(Review::class);
    }

    public function childReviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }
}
