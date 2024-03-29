<?php

namespace App\Models\V1\Addresses;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Country extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function regions(): HasMany
    {
        return $this->hasMany(Region::class);
    }
}
