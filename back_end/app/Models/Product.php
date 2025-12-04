<?php

namespace App\Models;

use App\Models\Details;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function socialMedia()
    {
        return $this->hasMany(SocialMedia::class);
    }
public function company()
{
    return $this->belongsTo(Company::class);
}
    public function details()
    {
        return $this->hasMany(Details::class, 'product_id');
    }

    public function branches()
     {
        return $this->hasMany(Details::class, 'cat_id');
    }

}
