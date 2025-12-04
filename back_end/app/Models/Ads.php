<?php

namespace App\Models;

use App\Models\Company;
use App\Models\Details;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
class Ads extends Model
{
    use HasFactory, HasSlug;

    protected $casts = [
        'product_ids' => 'array',
        'cats_ids' => 'array'
    ];



    public function getProductsAttribute()
    {
        $ids = is_array($this->product_ids)
            ? $this->product_ids
            : json_decode($this->product_ids, true);

        return Product::whereIn('id', $ids ?? [])->get();
    }


    public function category()
    {
        return $this->belongsTo(Category::class ,'cats_id');
    }
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function details()
    {
        return $this->hasMany(Details::class, 'ads_id');
    }


    public function products_details()
    {
        return $this->belongsToMany(Product::class, 'details', 'ads_id', 'product_id')
            ->withPivot(['type', 'count', 'date']);
    }

    public function prods()
    {
        return $this->belongsTo(Product::class,'product_ids');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'details', 'ads_id', 'product_id');
    }
    public function getSlugOptions():SlugOptions{
    return SlugOptions::create()->generateSlugsFrom('name')
    ->saveSlugsTo('slug');
}
public function getRouteKeyName(){
    return 'slug';
}
}