<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Category;
use App\Models\Product;
use App\Models\Ads;
use App\Models\Details;

class DashboardController extends Controller
{
public function index()
{
$totalVendors = Company::count();
$totalCategories = Category::count();
$totalProducts = Product::count();
$totalCampaigns = Ads::count();
$impressionsToday = 0;
$clicksToday = 0;

$recentCampaigns = Ads::with([
'company:id,name',
'category:id,name',
'products:id,name',
'details'
])
->latest()
->take(10)
->get()
->map(function($ad) {
return [
'id' => $ad->id,
'vendor_id' => $ad->company->id ?? null,
'vendor_name' => $ad->company->name ?? '',
'category_id' => $ad->category->id ?? null,
'category_name' => $ad->category->name ?? '',
'product_names' => $ad->products->pluck('name')->toArray(),
'name' => $ad->name,
'impressions' => 0,
'clicks' => 0,
'cost' => 0,
'conversions' => 0,
];
});

$impressionsChart = Details::selectRaw('DATE(created_at) as date, SUM(count) as total')
->where('created_at', '>=', now()->subDays(7))
->groupBy(\DB::raw('DATE(created_at)'))
->orderBy('date')
->get();


$clicksChart = Details::selectRaw('DATE(created_at) as date, SUM(count) as total')
->where('created_at', '>=', now()->subDays(7))
->groupBy(\DB::raw('DATE(created_at)'))
->orderBy('date')
->get();
$compact["view"] = "index";
$data = [
    'totalVendors' => $totalVendors,
    'totalCategories' => $totalCategories,
    'totalProducts' => $totalProducts,
    'totalCampaigns' => $totalCampaigns,
    'impressionsToday' => $impressionsToday,
    'clicksToday' => $clicksToday,
    'recentCampaigns' => $recentCampaigns,
    'impressionsChart' => $impressionsChart,
    'clicksChart' => $clicksChart,
];
return return_res($data, $compact ,\App\Http\Resources\Api\ProductResource::class);
}


}