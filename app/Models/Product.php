<?php

namespace App\Models;

use App\Models\Attribute as ModelsAttribute;
use App\Traits\HasFilter;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory;
    use HasFilter;
    protected $guarded = [];
    protected $with = ['category', 'supplier', 'generic', 'batches'];

    public function imageUrl(): Attribute
    {
        return Attribute::make(get: function ($value) {
            if (isset($this->attributes['image']) && $this->attributes['image'] && file_exists(public_path($this->attributes['image']))) {
                return asset($this->attributes['image']);
            } elseif (isset($this->category->image) && $this->category->image && file_exists(public_path('products/' . $this->category->image))) {
                return asset('products/' . $this->category->image);
            } else {
                return asset('images/new/no-image.jpg');
            }
        });
    }


    public function image(): Attribute
    {
        return Attribute::make(get: fn($value) => $this->image_url);
    }
    // public function imageUrl(): Attribute
    // {
    //     return Attribute::make(
    //         get: fn ($value) => $this->attributes['image'] ? asset('uploads/' . $this->attributes['image']) : $this->avatar()
    //     );
    // }
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_product')->withTimestamps();
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
    public function generic()
    {
        return $this->belongsTo(Generic::class);
    }


    public function batches()
    {
        return $this->belongsToMany(Purchase::class, 'purchase_product')->withPivot(
            'manufacture_date',
            'batch_name',
            'expiry_date',
            'purchased_unit',
            'purchase_quantity',
            'remaining_quantity',
            'supplier_rate',
            'total'
        )->withTimestamps()->wherePivot('expiry_date', '>', now());
    }

    public function hasQuantity()
    {

        return true;
    }

    public function scopeMostSold($query)
    {
        return $query->orderBy('sold_unit', 'desc');
    }

    public function price(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value ? $value / 100 : null,
            set: fn($value) => $value * 100,
        );
    }
    public function tradePrice(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value ? $value / 100 : null,
            set: fn($value) => $value * 100,
        );
    }


    public function boxPrice(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                return $value ? round(floatval($value), 2) / 100 : null;
            },
            set: function ($value) {
                return floatval($value) * 100;
            }
        );
    }

    public function stripPrice(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                return $value ? round(floatval($value), 2) / 100 : null;
            },
            set: function ($value) {
                return floatval($value) * 100;
            }
        );
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_product')->withPivot(['quantity', 'price']);
    }
    public function subproducts()
    {
        return $this->hasMany(Product::class, 'parent_id', 'id');
    }

    public function attributes()
    {
        return $this->hasMany(ModelsAttribute::class);
    }
    public function getVariationAttribute($value)
    {

        if ($value) {
            return json_decode($value);
        }
    }
}
