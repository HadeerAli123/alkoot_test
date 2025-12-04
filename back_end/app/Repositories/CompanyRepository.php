<?php

namespace App\Repositories;

use App\Models\Company;
use App\Interfaces\CompanyInterface;
use App\Models\Setting;
use App\Models\Product;
use App\Models\Category;
use App\Models\Ads;

use App\Models\SocialMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Yajra\DataTables\DataTables;
class CompanyRepository implements CompanyInterface
{
    public function index(Request $request)
    {
        // if ($request->ajax()) {
        //     return $this->getdata();
        // }
        // $users = Company::get();
        // dd($users);
        // return DataTables::of($users)->make(true);
        // return view('vendors.index');
        // return Company::with(['setting','categories'])->get();
        // $users = Company::with(['setting','categories'])->get();
        // dd($users);
        //
    //   return DataTables::of($users)->make(true);
        // return view('vendors.index');
        return Company::with(['setting','categories','domains'])->get();


    }

    public function getdata()
    {

        $query = Company::with(['setting','categories','domains']);

        return DataTables()
                ->eloquent($query)
                ->addColumn('cats_no', function ($one) {

                    $categoriesCount = $one->categories ? count($one->categories) : 0;

                    return '<a class="btn btn-info font-weight-100" href="' . route('cats.index', ['id' => $one->id]) . '"> ' . $categoriesCount . ' </a>';
                })
                ->addColumn('phone', function ($one) {

                    return $one->setting && isset($one->setting->phone) ? $one->setting->phone : '';
                })
                ->addColumn('img', function ($one) {

                    $logo = ($one->setting && isset($one->setting->logo)) ? $one->setting->logo : '';
                    return '<a href="' . new_asset($logo) . '" target="_blank"><img src="' . new_asset($logo) . '" class="img-fluid" style="width: 50px; height: 50px;"></a>';
                })
                ->addColumn('action', function ($one) {
                    return 'fffff';
                    // return '<a href="' . route('companies.edit', $one->id) . '" class="btn btn-primary btn-sm">تعديل</a>
                    //         <form action="' . route('companies.destroy', $one->id) . '" method="POST" style="display:inline;">
                    //             ' . csrf_field() . '
                    //             ' . method_field('DELETE') . '
                    //             <button type="submit" class="btn btn-danger btn-sm">حذف</button>
                    //         </form>';
                })
                ->rawColumns(['cats_no','img', 'action'])
                ->addIndexColumn()
                ->make(true);
    }

    public function show($id)
    {
        return Company::with('setting','domains')->find($id);
    }

    public function create()
    {
    }
   public function store($request)
    {
       
        
       
        $company = new Company();
        $company->name = $request->name;
        $company->has_product = $request->has('has_product') ? 1 : 0;
        $company->has_branch = $request->has('has_branch') ? 1 : 0;
        $company->description = $request->description ?? null;
        $company->domain = $request->domain;
        $company->created_by = Auth::user()->id ?? null;

        $company->save();

        $setting = new Setting();
        $setting->company_id = $company->id;
        if ($request->hasFile('logo')) {
            $setting->logo = UploadImage('company/logo', $request->logo);
        }
        $setting->phone = $request->phone ?? null;
        $setting->link = url('/') . '/' . $company->slug;
        $setting->theme_id = $request->theme_id ?? 4;
        $setting->created_by = Auth::user()->id ?? null;
        $setting->save();

        $socialTypes = [
                        'whatsapp', 'facebook', 'instagram', 'phone',
                        'snapchat', 'linkedin', 'website', 'x','visit','google_Map','google_Map_2','menu'
                    ];
        if ($company->has_branch && $request->has('branches') && is_array($request->branches)) {
            foreach ($request->branches as $branch) {
                $cats = new Category();
                $cats->name = $branch['name'] ;
                $cats->description = $branch['description'] ;
                $cats->company_id = $company->id;
                $cats->created_by = Auth::user()->id ?? null;
                if (!empty($branch['menu'])) {
                   $menu = UploadImage('category/menu', $branch['menu']);
                }
                $cats->save();

                if ($cats) {
                    foreach ($socialTypes as $type) {
                     
                        if (!empty($branch[$type])) {
                            $social = new SocialMedia();
                            $social->cat_id = $cats->id;
                            $social->type = $type;
                            $social->link = ($type == 'menu') ?  $menu : $branch[$type] ;
                             
                            $social->save();
                        }
                    }
                }
            }
             
        }

        if ($company->has_product && $request->has('products') && is_array($request->products)) {
            foreach ($request->products as $productData) {

                $product = new Product();
                $product->name = $productData['name'] ?? null;
                $product->location = $productData['location'] ?? null;
                $product->category_id = $productData['cat_id'] ?? null;
                $product->description = $productData['description'] ?? null;
                $product->company_id = $company->id;
                $product->created_by = Auth::user()->id ?? null;

                $imagePaths = [];
                if (!empty($productData['images']) && is_array($productData['images'])) {
                    foreach ($productData['images'] as $image) {
                        $path = UploadImage('product/images', $image);
                        $imagePaths[] = url($path);
                    }
                }
                $product->image = !empty($imagePaths) ? json_encode($imagePaths) : null;
                $product->save();

                
                if ($product) {
                    foreach ($socialTypes as $type) {
                        if (!empty($productData[$type])) {
                            $social = new SocialMedia();
                            $social->product_id = $product->id;
                            $social->type = $type;
                            $social->link = $productData[$type];
                            $social->save();
                        }
                    }
                }
               
            }
        }

        return $company;
    }
    public function update($request,$id)
    {
     
            $new = Company::with('setting','domains')->findOrFail($id);
            $new->name = $request->name;
            $new->domain = $request->domain;
            $new->description = $request->description ?? null;
            $new->updated_by = Auth::user()->id;

            $new->save();

            if($new)
            {

                $setting = Setting::where('company_id', $new->id)->first();
                if (!$setting) {
                    $setting = new Setting();
                    $setting->company_id = $new->id;  
                }
                if($request->has('logo'))
                {
                    $path = UploadImage('company/logo', $request->logo);
                }
                $setting->logo = $path ?? $setting->logo ;
                $setting->phone = $request->phone ?? null;
                $setting->link = url('/') . '/' . $request->slug;
                $setting->theme_id = $request->theme_id;
                $setting->save();

            }
            return $new;
        // return redirect()->route('companies.index')->with('success', 'تم التعديل بنجاح');

    }
 public function destroy($id)
    {

        $company = Company::findOrFail($id);
        // Delete related setting if exists
        $setting = Setting::where('company_id', $company->id)->first();
        if ($setting) {
            $setting->delete();
        }
        $cats = Category::where('company_id',$id)->get();
        if ($cats) {
            foreach($cats as $one)
            {
                $ads = Ads::where('company_id',$id)->get();
                foreach($ads as $ad)
                {
                    $ad->delete();
                }
                $one->delete();
            }
        }
        $company->delete();
        $new = Company::with('setting')->get();
        return $new;
        // return redirect()->route('companies.index')->with('success', 'تم الحذف بنجاح', $new);
    }
}




