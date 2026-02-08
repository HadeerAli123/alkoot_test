<?php

namespace App\Repositories;

use App\Interfaces\AdsInterface;
use App\Models\Ads;
use App\Models\Details;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;

class AdsRepository implements AdsInterface
{
    public function index(Request $request)
    {
        
      return Ads::with('company', 'company.domains')
            ->where('company_id', $request->comp_id)
            ->get();
                    
    }
  public function getData()
{
    $query = Ads::with('company.setting', 'category','company.domains')->orderBy('id','desc');

    $ads = Ads::with('company.setting', 'category','company.domains')->orderBy('id','desc')->get();

    if (request()->filled('comp_id')) {
        $query->where('company_id', request()->get('comp_id'));
    }
    if (request()->filled('status')) {
    $query->where('status', request()->get('status'));
}
     if (request()->filled('cat_id')) {
            $catId = request()->get('cat_id');

            $query->where(function ($q) use ($ads, $catId) {
                foreach ($ads as $ad) {
                    $catsIds = $ad->cats_ids;

                    if (is_string($catsIds)) {
                        $catsIds = json_decode($catsIds, true);
                    }

                    // $catsIds = is_array($catsIds) ? $catsIds : [];
                      
                if (in_array($catId, $catsIds) || in_array('all', $catsIds)) {
                        // dd($catsIds);
                        $q->orWhere('id', $ad->id); 
                    }
                }
            });
        }
        
    return DataTables::eloquent($query)
        ->addIndexColumn()
        ->addColumn('comp_name', function ($ad) {
            return $ad->company ? ($ad->company->name ?? '') : '';
        })
        ->addColumn('cat', function ($ad) {
            
             if ($ad->company && $ad->company->has_branch == 1) {
                $selectedCatsIds = is_array($ad->cats_ids) ? $ad->cats_ids : json_decode($ad->cats_ids, true);
                $selectedCatsIds = is_array($selectedCatsIds) ? $selectedCatsIds : [];

                if (!empty($selectedCatsIds) && $selectedCatsIds[0] != 'all') {
                    $cats = \App\Models\Category::whereIn('id', $selectedCatsIds)->get();
                } else {
                    $cats = \App\Models\Category::where('company_id', $ad->company->id)->get();
                }

                return $cats->pluck('name')->implode('<br>');
            } else {
                return '---';
            }
        })
        ->addColumn('prod', function ($ad) {
            if ($ad->company && $ad->company->has_product) {
                $selectedProdsIds = is_array($ad->product_ids) ? $ad->product_ids : json_decode($ad->product_ids, true);
                $selectedProdsIds = is_array($selectedProdsIds) ? $selectedProdsIds : [];
                $products = Product::whereIn('id', $selectedProdsIds)->get();
                return $products->pluck('name')->implode('<br>');
            } else {
                return '---';
            }
        })
        ->addColumn('img', function ($ad) {
            $url = new_asset($ad->image);
            
            return isset($ad->image) ? '<a href="' . $url . '" target="_blank"> مشاهدة</a>' : '-';
        })
       ->addColumn('link', function ($ad) {
            $themeId = ($ad->company && $ad->company->setting) ? ($ad->company->setting->theme_id ?? '') : '';
                     $domain = $ad->company->domains?->url ?? '';
                if (!$domain) {
                    return 'لا يوجد رابط';
                } else {
                    $domain = rtrim($domain, '/');
                    if (!preg_match('/^https?:\/\//', $domain)) {
                        $domain = 'http://' . $domain;
                    }
                    // استخدام الـ slug بدل الـ id لتوليد الرابط
                    $url = $domain . '/' . $ad->slug;
                    return '<a target="_blank" href="' . $url . '">الرابط</a>';
                }
            })
        ->addColumn('statistics', function ($ad) {
            return '<a href="' . route('ads_details.index', ['ads_id' => $ad->id]) . '"> الاحصائيات</a>';
        })
        // ->addColumn('visits_count', function ($ad) {
         
        //     return $ad->details->where('type','visit')->where('ads_id',$ad->id)->count();
        // })
    ->addColumn('visits_count', function ($ad) {
    $today = now()->format('Y-m-d');

    return Details::where('ads_id', $ad->id)
        ->where('type', 'visit')
        ->whereDate('date', $today)
        ->sum('count'); 



        
        })
        ->addColumn('ads_date', function ($ad) {
         
            return $ad->start_date .'<br/>' . $ad->end_date;
        })
        ->addColumn('qr_code', function ($ad) {
           $url = new_asset($ad->qr_code);
            return '<img src="'.$url.'" width="100px;">';
        })

        //////////////////خاص بال status 
        ->addColumn('status', function($row) {
  switch ($row->status) {
    case 'active':
        return '<span class="badge bg-success" style="background-color:#20c997; font-size:15px; color:white;">نشطة</span>';
    case 'inactive':
        return '<span class="badge bg-secondary" style="background-color:#6c757d; font-size:15px; color:white;">منتهية</span>';
    default:
        return '<span class="badge bg-warning text-dark" style="background-color:#ffc107; font-size:15px; color:white;">قيد الانتظار</span>';
}

})


       ->addColumn('actions', function ($ad) {
    $companyId = $ad->company ? $ad->company->id : '';

    $actions = '
        <div class="dropdown">
            <button class="btn btn-sm btn-primary dropdown-toggle" type="button" id="actionsDropdown' . $ad->id . '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                الإجراءات
            </button>
            <div class="dropdown-menu" aria-labelledby="actionsDropdown' . $ad->id . '">
                <a class="dropdown-item bg-primary-light text-primary" href="' . route('excel.export', $ad->id) . '">تصدير اكسيل</a>
    ';

    // الحالة حسب status
    if ($ad->status === 'inactive') {
        $actions .= '<a class="dropdown-item bg-warning-light text-warning" href="' . route('ads_.edit', $ad->id) . '">تجديد الحملة</a>';
    } elseif ($ad->status === 'pending') {
    $actions .= '<a class="dropdown-item bg-success-light text-success" href="#" onclick="startNow(' . $ad->id . ')">بدء الآن</a>';
      $actions .=     '<a class="dropdown-item bg-info-light text-info" href="' . route('ads_.edit', $ad->id) . '" >تعديل</a>';

    } elseif ($ad->status === 'active') {
        $actions .= '<a class="dropdown-item bg-danger-light text-danger" href="' . route('ads_.edit', $ad->id) . '">إيقاف الحملة</a>';
              $actions .=     '<a class="dropdown-item bg-info-light text-info" href="' . route('ads_.edit', $ad->id) . '" >تعديل</a>';

    }

    $actions .= '
            </div>
        </div>
    ';

    return $actions;
})
->rawColumns(['img', 'link', 'statistics', 'actions', 'cat', 'prod', 'qr_code', 'ads_date', 'visits_count', 'status'])
->make(true);

        
}

     public function show($slug)
{
    $ad = Ads::with('company', 'company.domains', 'category')
        ->where('slug', $slug)
        ->firstOrFail();

    return $ad;
}
    public function create()
    {
    }
    public function store($request)
    {
        // dd($request->all());
      $new = new Ads();

      if (is_array($request->product_ids) && isset($request->product_ids[0]) && $request->product_ids[0] === 'all')
        {
            $products = Product::where('company_id',$request->company_id)->get();
            foreach($products as $one)
            {
                $prods_ids[] = $one->id;
            }
            $new->product_ids = json_encode($prods_ids);
        }

        else
        {
             $new->product_ids = json_encode($request->product_ids);
        }


        if (is_array($request->product_ids) && isset($request->product_ids[0]) && $request->product_ids[0] === 'all') {
            $cats = Category::where('company_id', $request->company_id)->get();
            $cat_ids = [];
            foreach ($cats as $one) {
                $cat_ids[] = $one->id;
            }
            $new->cats_ids = !empty($cat_ids) ? json_encode($cat_ids) : null;
        } elseif (!empty($request->cats_ids)) {
            $new->cats_ids = json_encode($request->cats_ids);
        } else {
            $new->cats_ids = null;
        }
    //  dd( $new->cats_ids );
        $new->name = $request->name;
    $new->start_date = $request->start_date;
    $new->end_date = $request->end_date ?? null;
    $new->amount_per_day = $request->amount_per_day;
    $new->company_id = $request->company_id;
    $new->phone = $request->phone;
    $new->note = $request->note ?? null;
    $new->number_days = $request->number_days;
    $new->total_amount = $request->total_amount;
    $new->created_by = Auth::user()->id;

    $today = now()->toDateString();
    if ($request->start_date > $today) {
        $new->status = 'pending';
    } elseif ($request->end_date && $request->end_date < $today) {
        $new->status = 'inactive'; // انتهت
    } else {
        $new->status = 'active'; // شغالة دلوقتي
    }


        if ($request->hasFile('image')) {
            $path = UploadImage('ads/image', $request->image);
        }
         $new->image = $path ?? null;
        $new->save();
        // dd($request->all());
        return $new;

    }

    public function update($request,$id)
    {
            $new =  Ads::with('company')->findOrFail($id);
            $new->name = $request->name;
            $new->start_date = $request->start_date;
            $new->end_date = $request->end_date ?? null;
            $new->amount_per_day = $request->amount_per_day;
            $new->product_ids = json_encode($request->product_ids);
            $new->cats_ids = json_encode($request->cats_ids );
            $new->status = 'active';
            $new->note = $request->note ?? null;
            $new->number_days = $request->number_days;
            $new->total_amount = $request->total_amount;
            $new->phone = $request->phone;


            $new->updated_by = Auth::user()->id;


               $today = now()->toDateString();
    if ($request->start_date > $today) {
        $new->status = 'pending'; // لسه مجاش وقتها
    } elseif ($request->end_date && $request->end_date < $today) {
        $new->status = 'inactive'; // انتهت
    } else {
        $new->status = 'active'; // شغالة حالياً
    }
            if ($request->hasFile('image')) {
                $path = UploadImage('ads/image', $request->image);
            }
            $new->image = $path ?? $new->image;
            $new->save();
            return $new;
    }

    public function destroy($id)
    {
        $ads = Ads::findOrFail($id);

        $data =  Ads::with('company','details')->get();
             $ads->delete();
        return $data;
    }


    
public function getAll(Request $request)
{
    return Ads::with('category')
        ->when(
            $request->filled('cat_id') && $request->cat_id !== 'all',
            function ($query) use ($request) {
                $query->where('cats_ids', (int) $request->cat_id);
            }
        )
        ->get();
}
 public function startNow($id){
    $ads= Ads::findOrFail($id);
    
    
if ($ads->status=='pending'){
$ads->status = 'active';
$ads->start_date = now();
$ads->save();

      return response()->json(['success' => true, 'message' => 'تم بدء الحملة بنجاح ']);
    }

    return response()->json(['success' => false, 'message' => 'لا يمكن بدء الحملة في حالتها الحالية ']);
}


}