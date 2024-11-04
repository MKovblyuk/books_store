<?php

namespace App\Models\V1\Orders;

use App\Enums\PaymentMethods;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PaymentMethod extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'method',
    ];

    protected $casts = [
        'method' => PaymentMethods::class,
    ];

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
