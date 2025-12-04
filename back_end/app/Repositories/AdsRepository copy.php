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
        return Ads::with('company','company.domains')->where('company_id', $request->comp_id)->get();
    }
  public function getData()
{
    $query = Ads::with('company.setting', 'category','company.domains')->orderBy('id','desc');

    if (request()->filled('comp_id')) {
        $query->where('company_id', request()->get('comp_id'));
    }
    if (request()->filled('cats')) {
        $cats = request()->get('cats');
    
        foreach ((array)$cats as $catId) {
            $query->orWhereJsonContains('cats_ids', (int) $catId);
        }
    }

    // if (request()->filled('cats')) {
    //     $cats = request()->get('cats');
    
         $query->where(function ($q) use ($cats) {
        foreach ($cats as $catId) {
            $q->orWhereJsonContains('cats_ids', (int) $catId);

        }
        dd($q->get());
    });
    // }


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
            return '<a href="' . $url . '" target="_blank"> مشاهدة</a>';
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
                $url = $domain . '/' . $ad->id;
                return '<a target="_blank" href="' . $url . '">الرابط</a>';
            }
        })
        ->addColumn('statistics', function ($ad) {
            return '<a href="' . route('ads_details.index', ['ads_id' => $ad->id]) . '">مشاهدة الاحصائيات</a>';
        })
        ->addColumn('actions', function ($ad) {
            $companyId = $ad->company ? $ad->company->id : '';
              //  $dropdown = '
            //     <div class="dropdown">
            //         <button class="btn btn-sm btn-primary dropdown-toggle" type="button" id="actionsDropdown' . $ad->id . '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            //         الإجراءات
            //         </button>
            //         <div class="dropdown-menu" aria-labelledby="actionsDropdown' . $ad->id . '">
            //             <a class="dropdown-item bg-primary-light text-primary" href="' . route('excel.export', $ad->id) . '">تصدير اكسيل</a>

            //             <!-- Edit button triggers modal -->
            //             <button type="button" class="dropdown-item bg-info-light text-info" data-toggle="modal" data-target="#editModal' . $ad->id . '">
            //                 تعديل
            //             </button>

            //             <!-- Delete form -->
            //             <form action="' . route('ads_.destroy', ['ads_' => $ad->id, 'comp_id' => $companyId ]) . '" method="POST" onsubmit="return confirm(\'هل أنت متأكد من الحذف ؟ \');" style="display:inline;">
            //                 ' . csrf_field() . '
            //                 ' . method_field('DELETE') . '
            //                 <button type="submit" class="dropdown-item bg-warning-light text-warning">
            //                     حذف
            //                 </button>
            //             </form>
            //         </div>
            //     </div>';

                // Modal for edit
                // $modal = 
                // '<div id="editModal' . $ad->id . '" class="modal fade">
                //             <div class="modal-dialog modal-dialog-centered modal-xl">
                //                 <div class="modal-content">
                //                     <!-- Modal Body -->
                //                     <div class="modal-body">
                //                         <form action="'. route('ads_.update', $ad->id) . '" method="POST"
                //                             enctype="multipart/form-data">
                //                              ' . csrf_field() . '
                //                             ' . method_field('PUT') . '
                //                             <div class="contact-account-setting media-body d-flex justify-content-between align-items-center"
                //                                 style="background: #e3e4e6; border-radius: 12px; padding-top: 20px; padding-bottom: 15px; margin-bottom: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.04);">
                //                                 <h4 class="mb-0"
                //                                     style="font-weight: bold; letter-spacing: 1px; text-align: left;padding-right: 10px;">
                //                                     إضف جديد</h4>
                //                                 <button type="button" class="close ml-2" data-dismiss="modal"
                //                                     aria-label="Close"
                //                                     style="padding-left: 10px;font-size: 2rem; background: none; border: none;">
                //                                     <span aria-hidden="true">&times;</span>
                //                                 </button>
                //                             </div>
                                           
                //                             <div class="container-fluid row col-lg-12">
                //                                 <div class="col-lg-6">
                //                                     <div class="mb-4">
                //                                         <label for="name" class="mb-2 black bold">اسم الحملة <span
                //                                                 class="text-danger">*</span></label>
                //                                         <input type="text" class="theme-input-style" id="name" name="name"
                //                                             placeholder="أدخل اسم الحملة">
                //                                     </div>
                //                                 </div>
                //                                 <input type="hidden" name="company_id" value="{{  '.request()->get('comp_id').' }}">
                //                                 <div class="col-lg-6">
                //                                     <div class="form-group mb-4">
                //                                         <label for="start_date" class="mb-2 black bold">تاريخ البدء <span
                //                                                 class="text-danger">*</span></label>
                //                                         <input type="date" class="theme-input-style" id="start_date"
                //                                             name="start_date">
                //                                     </div>
                //                                 </div>
                //                                 <div class="col-lg-6">
                //                                     <div class="form-group mb-4">
                //                                         <label for="end_date" class="mb-2 black bold">تاريخ النهاية <span
                //                                                 class="text-danger">*</span></label>
                //                                         <input type="date" class="theme-input-style" id="end_date"
                //                                             name="end_date">
                //                                     </div>
                //                                 </div>
                //                                 <div class="col-lg-6">
                //                                     <div class="form-group mb-4">
                //                                         <label for="amount_per_day" class="mb-2 black bold">قيمة الاعلان لليوم
                //                                             <span class="text-danger">*</span></label>
                //                                         <input type="number" class="theme-input-style" id="amount_per_day"
                //                                             name="amount_per_day">
                //                                     </div>
                //                                 </div>
                //                                 <div class="col-lg-6">
                //                                     <div class="form-group mb-4">
                //                                         <label for="number_days" class="mb-2 black bold">عدد الايام</label>
                //                                         <input type="text" class="theme-input-style" id="number_days"
                //                                             name="number_days">
                //                                     </div>
                //                                 </div>
                //                                 <div class="col-lg-6">
                //                                     <div class="form-group mb-4">
                //                                         <label for="total_amount" class="mb-2 black bold">اجمالى القيمة</label>
                //                                         <input type="number" class="theme-input-style" id="total_amount"
                //                                             name="total_amount">
                //                                     </div>
                //                                 </div>
                //                                 <div class="col-lg-6">
                //                                     <div class="form-group mb-4">
                //                                         <label for="number_days" class="mb-2 black bold">هاتف الحملة </label>
                //                                         <input type="number" class="theme-input-style" name="phone">
                //                                     </div>
                //                                 </div>
                //                                 <div class="col-lg-6">
                //                                     <div class="form-group mb-4">
                //                                         <label for="ad_image" class="mb-2 black bold"> رفع صورة او فيديو او
                //                                             PDF</label>
                //                                         <input type="file" class="theme-input-style" id="ad_image" name="image"
                //                                             accept="image/*,video/*,application/pdf">
                //                                     </div>
                //                                 </div>
                //                                 <div class="col-lg-6" id="branches">
                //                                     <div class="form-group mb-4">
                //                                         <label for="cats_ids" class="mb-2 black bold">الفروع</label>
                //                                         <select class="theme-input-style" id="cats_ids" name="cats_ids[]"
                //                                             multiple style="min-height: 120px; height: 160px;">
                //                                             @php
                //                                             $cats = App\Models\Category::all();
                //                                             @endphp
                //                                             <option value="all">الكل </option>
                //                                             @foreach ($cats as $comp)
                //                                             <option value="{{ $comp->id }}">{{ $comp->name }} </option>
                //                                             @endforeach
                //                                         </select>
                //                                     </div>
                //                                 </div>
                //                                 <div class="col-lg-6" id="products" style="display:none">
                //                                     <div class="form-group mb-4">
                //                                         <label for="product_ids" class="mb-2 black bold">المنتجات</label>
                //                                         <select class="theme-input-style" id="product_ids" name="product_ids[]"
                //                                             multiple style="min-height:120px; height:150px;">
                //                                         </select>
                //                                     </div>
                //                                 </div>
                //                                 <div class="col-lg-6">
                //                                     <div class="form-group mb-4">
                //                                         <label for="note" class="mb-2 black bold">ملاحظة</label>
                //                                         <textarea class="theme-input-style" id="note" name="note"
                //                                             rows="3"></textarea>
                //                                     </div>
                //                                 </div>
                //                             </div>
                //                             <div class="d-flex justify-content-center pt-3"
                //                                 style="    padding-bottom: 10px;">
                //                                 <button type="submit" class="btn btn-primary ml-3">حفظ</button>
                //                                 <button type="reset" class="btn btn-secondary"
                //                                     data-dismiss="modal">إلغاء</button>
                //                             </div>
                //                         </form>
                //                     </div>
                //                     <!-- End Modal Body -->
                //                 </div>
                //             </div>
                //         </div>'
                // ;

                // return $dropdown . $modal;
            return '
            <div class="dropdown">
                <button class="btn btn-sm btn-primary dropdown-toggle" type="button" id="actionsDropdown' . $ad->id . '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                الإجراءات
                </button>
                <div class="dropdown-menu" aria-labelledby="actionsDropdown' . $ad->id . '">
                <a class="dropdown-item bg-primary-light text-primary" href="'. route('excel.export',$ad->id).'">تصدير اكسيل</a>
                <form action="' . route('ads_.destroy', ['ads_' => $ad->id, 'comp_id' => $companyId ]) . '" method="POST" onsubmit="return confirm(\'هل أنت متأكد من الحذف ؟ \');" style="display:inline;">
                    ' . csrf_field() . '
                    ' . method_field('DELETE') . '
                    <button type="submit" class="dropdown-item bg-warning-light text-warning">
                    حذف
                    </button>
                </form>
                </div>
            </div>
            ';
        })
        ->rawColumns(['img', 'link', 'statistics','actions','cat','prod'])
        ->make(true);
}

    public function show($id)
    {
        return Ads::with('company','company.domains')->find($id);
    }

    public function create()
    {
    }
    public function store($request)
    {
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
        // $new->product_ids = json_encode($request->product_ids);
        // $new->cats_ids = json_encode($request->cats_ids );
        $new->status = 'active';
        $new->note = $request->note ?? null;
        $new->number_days = $request->number_days;
        $new->total_amount = $request->total_amount;
        $new->created_by = Auth::user()->id;

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
            $new->company_id = $request->company_id;
            $new->product_ids = json_encode($request->product_ids);
            $new->cats_ids = json_encode($request->cats_ids );
            $new->status = 'active';
            $new->note = $request->note ?? null;
            $new->number_days = $request->number_days;
            $new->total_amount = $request->total_amount;
            $new->phone = $request->phone;

            $new->updated_by = Auth::user()->id;
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
        $ads->delete();

        $data =  Ads::with('company')->get();
        return $data;
    }

    public function getAll(Request $request)
    {

        return  Ads::with('company')
                      ->when($request->company_id, function ($query) use ($request) {
                                $query->where('company_id', $request->company_id);
                        })
                     ->get();

    }

}