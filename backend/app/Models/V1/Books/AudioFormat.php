<?php

namespace App\Models\V1\Books;

use App\Services\Books\AudioBookStorageService;
use App\Services\Books\BookStorageServiceInterface;
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
        'path',
        'book_id',

    ];

    protected $casts = [
        'price' => 'decimal:2',
        'discount' => 'decimal:2',
    ];

    protected $hidden = [
        'path',
    ];

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    public function getFileStorageService(): BookStorageServiceInterface
    {
        return new AudioBookStorageService($this->path);
    }
}
