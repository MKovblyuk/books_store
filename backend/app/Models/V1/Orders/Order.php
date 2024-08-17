<?php

namespace App\Models\V1\Orders;

use App\Enums\OrderStatus;
use App\Models\V1\Addresses\Address;
use App\Models\V1\Books\Book;
use App\Models\V1\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'status',
        'user_id',
        'address_id',
        'shipping_method_id',
        'total_price',
        'payment_method_id',
    ];

    protected $casts = [
        'status' => OrderStatus::class,
    ];

    public function paymentMethod(): BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class);
    }

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
            ->withPivot('book_format', 'quantity');
    }

    public function details(): array
    {
        $details = [];

        foreach($this->books as $book){
            unset($book->details['order_id']);
            $details[] = $book->details;
        }

        return $details;
    }

    public function forceDeleteWithDetails()
    {
        DB::transaction(function () {
            DB::table('book_order')->where('order_id', $this->id)->delete();
            $this->forceDelete();
        });
    }

}
