<?php

namespace App\Models\V1\Books;

use App\Exceptions\General\IncorrectDataException;
use App\Interfaces\General\HasQuantityInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaperFormat extends Model implements HasQuantityInterface
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
        'price' => 'decimal:2',
        'discount' => 'decimal:2',
    ];

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $value)
    {
        if ($value < 0) {
            throw new IncorrectDataException();
        }
        
        $this->quantity = $value;
        $this->save();
    }

    public function increaseQuantity(int $value)
    {
        $this->setQuantity($this->quantity + $value);
    }

    public function decreaseQuantity(int $value)
    {
        $this->setQuantity($this->quantity - $value);
    }
}
