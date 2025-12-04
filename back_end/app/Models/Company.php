<?php

namespace App\Models;

use App\Models\Setting;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Company extends Model
{
    use HasFactory;


    public function setting()
    {
        return $this->hasOne(Setting::class);
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }
    public function categoriesCount()
    {
        return $this->categories()->count();
    }
    public function ads()
    {
        return $this->hasMany(Ads::class);
    }
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function domains()
    {
        return $this->hasone(Domain::class,'id', 'domain');
    }
}
