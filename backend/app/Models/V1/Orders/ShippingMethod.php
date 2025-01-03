<?php

namespace App\Models\V1\Orders;

use App\Enums\ShippingMethods;
use App\Models\V1\Addresses\DeliveryPlace;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ShippingMethod extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    protected $casts = [
        'name' => ShippingMethods::class
    ];

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function deliveryPlaces(): HasMany
    {
        return $this->hasMany(DeliveryPlace::class);
    }
}
