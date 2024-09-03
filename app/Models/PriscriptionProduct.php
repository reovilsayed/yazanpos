<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\Pivot;

class PriscriptionProduct extends Pivot
{
    public function scheduled(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => (object) json_decode($value),
            set: fn ($value) => json_encode($value)
        );
    }
}
