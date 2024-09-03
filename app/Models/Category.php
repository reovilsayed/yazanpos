<?php

namespace App\Models;

use App\Traits\HasFilter;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Category extends Model
{
    use HasFactory;
    use HasFilter;
    protected $guarded = [];
    public function imageUrl(): Attribute
    {
        return Attribute::make(get: function ($value) {
            if (isset($this->attributes['image']) && $this->attributes['image'] && Storage::exists($this->attributes['image'])) {
                return Storage::url($this->attributes['image']);
            } elseif (isset($this->category->image) && $this->category->image && Storage::exists($this->category->image)) {
                return Storage::url($this->category->image);
            } else {
                return asset('images/new/no-image.jpg');
            }
        });
    }

    public function image(): Attribute
    {
        return Attribute::make(get: fn ($value) => $this->image_url);
    }
}
