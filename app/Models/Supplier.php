<?php

namespace App\Models;

use App\Traits\HasFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Supplier extends Model
{
    use HasFactory;
    use HasFilter;

    protected $fillable = [
        'name',
        'logo',
        'registration_number',
        'vat_number',
        'industry_type',
        'contact_person',
        'contact_person_designation',
        'contact_person_email',
        'contact_person_phone',
        'company_email',
        'company_phone',
        'address',
        'city',
        'country',
        'website',
    ];
    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'like', '%' . $search . '%')
            ->orWhere('registration_number', 'like', '%' . $search . '%')
            ->orWhere('vat_number', 'like', '%' . $search . '%')
            ->orWhere('industry_type', 'like', '%' . $search . '%')
            ->orWhere('contact_person', 'like', '%' . $search . '%')
            ->orWhere('contact_person_designation', 'like', '%' . $search . '%')
            ->orWhere('contact_person_email', 'like', '%' . $search . '%')
            ->orWhere('contact_person_phone', 'like', '%' . $search . '%')
            ->orWhere('company_email', 'like', '%' . $search . '%')
            ->orWhere('company_phone', 'like', '%' . $search . '%')
            ->orWhere('address', 'like', '%' . $search . '%')
            ->orWhere('city', 'like', '%' . $search . '%')
            ->orWhere('country', 'like', '%' . $search . '%')
            ->orWhere('website', 'like', '%' . $search . '%');
    }
    // Add any additional relationships or methods as needed

    public function imageUrl(): Attribute
    {
  
        return Attribute::make(get: fn ($value) => asset($this->attributes['logo']));

        // return Attribute::make(get: fn ($value) => Storage::url($this->attributes['image']));
    }
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
