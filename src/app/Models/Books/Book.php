<?php

namespace App\Models\Books;

use App\Enums\BookFormat;
use App\Models\Orders\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Collection as SupportCollection;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'publication_year',
        'language',
        'cover_image_url',
        'published',
        'published_at',
        'publisher_id',
        'category_id',
        'paper_format_id',
        'audio_format_id',
        'electronic_format_id',
    ];

    public function authors(): BelongsToMany
    {
        return $this->belongsToMany(Author::class);
    }

    public function paperFormat(): HasOne
    {
        return $this->hasOne(PaperFormat::class);
    }

    public function electronicFormat(): HasOne
    {
        return $this->hasOne(ElectronicFormat::class);
    }

    public function audioFormat(): HasOne
    {
        return $this->hasOne(AudioFormat::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function publisher(): BelongsTo
    {
        return $this->belongsTo(Publisher::class);
    }

    public function fragments(): HasMany
    {
        return $this->hasMany(Fragment::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function likedByUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'liked_books');
    }

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class)
            ->as('details')
            ->withPivot('book_type', 'quantity', 'total_price');
    }

    public function availableFormats(): SupportCollection
    {
        $formats = [];

        if ($this->paperFormat) $formats[] = BookFormat::Paper;
        if ($this->electronicFormat) $formats[] = BookFormat::Electronic;
        if ($this->audioFormat) $formats[] = BookFormat::Audio;

        return collect($formats);
    }

    public function likesCount(): int
    {
        return $this->likedByUsers()->count();
    }

}
