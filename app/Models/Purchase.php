<?php

namespace App\Models;

use App\Traits\HasFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Purchase extends Model
{
    use HasFactory;
    use HasFilter;

    protected $casts = ['purcahsed_at' => 'datetime'];
    
    public function products()
    {
        return $this->belongsToMany(Product::class, 'purchase_product')->withPivot(
            'manufacture_date',
            'batch_name',
            'expiry_date',
            'purchased_unit',
            'purchase_quantity',
            'purchase_unit_quantity',
            'remaining_quantity',
            'supplier_rate',
            'total'
        )->withTimestamps();
    }





    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
