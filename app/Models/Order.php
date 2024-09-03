<?php

namespace App\Models;

use App\Traits\HasFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
class Order extends Model
{
    use HasFactory;
    use HasFilter;

    protected $guarded = [];
    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id')->withDefault();
    }

    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('quantity', 'price', 'profit');
    }
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function total(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? $value / 100 : null,
            set: fn ($value) => $value * 100,
        );
    }
    public function subTotal(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? $value / 100 : null,
            set: fn ($value) => $value * 100,
        );
    }
    public function discount(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? $value / 100 : null,
            set: fn ($value) => $value * 100,
        );
    }
    public function paid(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? $value / 100 : null,
            set: fn ($value) => $value * 100,
        );
    }
    public function due(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? $value / 100 : null,
            set: fn ($value) => $value * 100,
        );
    }
    public function profit(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? $value / 100 : null,
            set: fn ($value) => $value * 100,
        );
    }
}
