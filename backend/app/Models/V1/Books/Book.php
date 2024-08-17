<?php

namespace App\Models\V1\Books;

use App\Enums\BookFormat;
use App\Models\V1\Orders\Order;
use App\Models\V1\User;
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
        'published_at',
        'publisher_id',
        'category_id',
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
            ->withPivot('book_format', 'quantity', 'total_price');
    }

    public function availableFormats(): SupportCollection
    {
        $formats = [];

        if ($this->paperFormat) $formats[] = BookFormat::Paper;
        if ($this->electronicFormat) $formats[] = BookFormat::Electronic;
        if ($this->audioFormat) $formats[] = BookFormat::Audio;

        return collect($formats);
    }

    public function hasFormat(BookFormat $format): bool
    {
        return $this->availableFormats()->contains($format);
    }

    public function getFormat(BookFormat $format): Model|null
    {
        if ($format === BookFormat::Paper) return $this->paperFormat;
        if ($format === BookFormat::Electronic) return $this->electronicFormat;
        if ($format === BookFormat::Audio) return $this->audioFormat;
    }

    public function deleteFormat(BookFormat $format): bool
    {
        return $this->getFormat($format)
            ? $this->getFormat($format)->delete()
            : true;
    }

    public function getPrice(BookFormat $format): float
    {
        return $this->getFormat($format)->price;
    }

    public function likesCount(): int
    {
        return $this->likedByUsers()->count();
    }
}
