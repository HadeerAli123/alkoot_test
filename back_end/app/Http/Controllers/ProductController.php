<?php

namespace App\Http\Controllers;

use App\Interfaces\ProductInterface;
use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Company;

class ProductController extends Controller
{
    protected $repo;
    public function __construct(ProductInterface $repo)
    {
        $this->repo = $repo;
    }
    public function index(Request $request)
    {
        $data = $this->repo->index($request);
        // dd($data);
        // $comp_id = Category::findOrFail($request->cat_id)->company_id;
        // $comp_name = Company::findOrFail($comp_id)->name;

        $compact[1]['title'] =  "المشروعات";
        $compact[1]['url'] = route('companies.index');
        // $compact[2]['title'] =   "الفروع";
        // $compact[2]['url'] = route('cats.index',['id'=> $comp_id]);
        $compact[2]['title'] = 'المنتجات';
        $compact[2]['url'] = "javascript:void(0);";

        $compact["view"] = "products";
        //  Product::where('category_id',$request->cat_id)->get();
        return return_res($data, $compact ,\App\Http\Resources\Api\ProductResource::class);
    }

    
    public function create()
    {
        
    }

    public function store(StoreProductRequest $request)
    {
        $this->repo->store($request);
        //  $comp_id = Category::findOrFail($request->cat_id)->company_id;
        // $comp_name = Company::findOrFail($comp_id)->name;

        // $compact[1]['title'] =  "المشروعات";
        // $compact[1]['url'] = route('companies.index');
        // $compact[2]['title'] =   "الفروع";
        // $compact[2]['url'] = route('cats.index',['id'=> $comp_id]);
        // $compact[3]['title'] = $comp_name;
        // $compact[3]['url'] = "javascript:void(0);";

        // $compact["view"] = "products";
        // $data = Product::where('category_id',$request->cat_id)->get();
        // return return_res($data, $compact ,\App\Http\Resources\Api\ProductResource::class);

        return redirect()->back()->with('success','تم الاضافة بنجاح');
    }

    public function show($id)
    {
        $data = $this->repo->show($id);
        
        // $category_id = Product::findOrFail($id)->category_id;
        
        $comp_id = Product::findOrFail($id)->company_id;
        $comp_name = Company::findOrFail($comp_id)->name;

        $compact[1]['title'] =  "المشروعات";
        $compact[1]['url'] = route('companies.index');
        $compact[2]['title'] =   "الفروع";
        $compact[2]['url'] = route('cats.index',['id'=> $comp_id]);
        $compact[3]['title'] = $comp_name;
        $compact[3]['url'] = "javascript:void(0);";

         $compact["view"] = "products";

        return return_res($data, $compact ,\App\Http\Resources\Api\ProductResource::class);
    }

    public function edit(Product $product)
    {
        //
    }

    public function update(UpdateProductRequest $request, $id)
    {
       
        $this->repo->update($request,$id);
        return redirect()->back()->with('success','تم التعديل بنجاح');

        //  $comp_id = Category::findOrFail($request->cat_id)->company_id;
        // $comp_name = Company::findOrFail($comp_id)->name;

        // $compact[1]['title'] =  "المشروعات";
        // $compact[1]['url'] = route('companies.index');
        // $compact[2]['title'] =   "الفروع";
        // $compact[2]['url'] = route('cats.index',['id'=> $comp_id]);
        // $compact[3]['title'] = $comp_name;
        // $compact[3]['url'] = "javascript:void(0);";

        // $compact["view"] = "products";
        // $data = Product::where('category_id',$request->cat_id)->get();
        // return return_res($data, $compact ,\App\Http\Resources\Api\ProductResource::class);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->repo->destroy($id);
        return redirect()->back()->with('success','تم الحذف بنجاح');

        // dd($data);
        // $category_id = Product::findOrFail($id)->category_id;
        
        // $comp_id = Category::findOrFail($category_id)->company_id;
        // $comp_name = Company::findOrFail($comp_id)->name;

        // $compact[1]['title'] =  "المشروعات";
        // $compact[1]['url'] = route('companies.index');
        // $compact[2]['title'] =   "الفروع";
        // $compact[2]['url'] = route('cats.index',['id'=> $comp_id]);
        // $compact[3]['title'] = $comp_name;
        // $compact[3]['url'] = "javascript:void(0);";

        // $compact["view"] = "products";

        // $data = Product::with('category','socialMedia')->where('category_id',$category_id)->get();
        // return return_res($data, $compact ,\App\Http\Resources\Api\ProductResource::class);
    }
}
