<?php

namespace App\Models;

use App\Traits\HasFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Generic extends Model
{
    use HasFactory;
    use HasFilter;

    protected $fillable = [
        'name',
        'description',
        'url'
    ];
    
}
