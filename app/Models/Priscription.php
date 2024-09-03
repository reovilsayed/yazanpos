<?php

namespace App\Models;

use App\Traits\HasFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Priscription extends Model
{
    use HasFactory;
    use HasFilter;
    protected $guarded = [];

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }
    public function products()
    {
        return $this->belongsToMany(Product::class)->using(PriscriptionProduct::class)->withPivot('scheduled', 'dose')->withTimestamps();
    }
    public function childs()
    {
        return $this->hasMany(Priscription::class);
    }
    public function scopeFilter($query)
    {
        // dd( request('search'));
        return $query
            ->when(
                request()->has('customer'),
                function ($q) {
                    $q->whereHas('customer', function ($query) {
                        return $query->where('name', request()->customer)->orWhere('phone', request()->customer);
                    });
                }
            );
    }
}
