<?php

namespace App\Models\V1\Addresses;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PostalCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'postal_code',
        'settlement_id',
    ];

    public function settlement(): BelongsTo
    {
        return $this->belongsTo(Settlement::class);
    }
}
