<?php

namespace App\Models\Books;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Kalnoy\Nestedset\NodeTrait;

class Category extends Model
{
    use HasFactory;
    use NodeTrait;

    protected $fillable = [
        'name',
        'parent_category_id',
    ];

    public function books(): HasMany
    {
        return $this->hasMany(Book::class);
    }

    public function subCategories(): HasMany
    {
        return $this->hasMany(Category::class);
    }

    public function parentCategory(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
