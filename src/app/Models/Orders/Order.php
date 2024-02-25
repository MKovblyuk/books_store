<?php

namespace App\Models\Orders;

use App\Models\Addressess\Address;
use App\Models\Books\Book;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'status',
        'user_id',
        'address_id',
        'shipping_method_id',
    ];

    protected $casts = [
        'date' => 'datetime',
    ];

    public function shippingMethod(): BelongsTo
    {
        return $this->belongsTo(ShippingMethod::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }

    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Book::class)
            ->as('details')
            ->withPivot('book_type', 'quantity', 'total_price');
    }
}
