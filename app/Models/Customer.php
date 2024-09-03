<?php

namespace App\Models;

use App\Traits\HasFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    use HasFilter;
    protected $guarded = [];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
