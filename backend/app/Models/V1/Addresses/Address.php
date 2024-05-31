<?php

namespace App\Models\V1\Addresses;

use App\Models\V1\Orders\Order;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'settlement_name',
        'street_name',
        'street_number',
        'postal_code',
        'district_id',
    ];

    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
