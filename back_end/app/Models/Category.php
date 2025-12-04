<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
class Category extends Model
{
    use HasFactory, HasSlug;
    protected $fillable = [
        'name',
    ];
    public function products()
    {
        return $this->hasMany(Product::class);
    }
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function socialMedia()
    {
        return $this->hasMany(SocialMedia::class,'cat_id');
    }
   public function getSlugOptions():SlugOptions{
    return SlugOptions::create()->generateSlugsFrom('name')
    ->saveSlugsTo('slug');
}
public function getRouteKeyName(){
    return 'slug';
}
} 