<?php

namespace App\Models;

use App\Models\Ads;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Details extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function ads()
    {
        return $this->belongsTo(Ads::class, 'ads_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
