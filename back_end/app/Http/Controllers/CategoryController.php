<?php

namespace App\Http\Controllers;

use App\Interfaces\CategoryInterface;
use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use Illuminate\Http\Request;
use App\Models\Company;


class CategoryController extends Controller
{
      protected $repo;
    public function __construct(CategoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function index(Request $request)
    {
        $data = $this->repo->index($request);
        // $company_name = Company::findOrFail($request->id)->name;
        
        $compact[1]['title'] =  "المشروعات";
        $compact[1]['url'] = route('companies.index');
        $compact[2]['title'] =   "الفروع";
        $compact[2]['url'] = "javascript:void(0);";

        $compact["view"] = "cats.index";
            
        return return_res($data, $compact ,\App\Http\Resources\Api\CategoryResource::class);
    }
    public function create()
    {
        //
    }

    public function store(StoreCategoryRequest $request)
    {
        $this->repo->store($request);

        // $company_name = Company::findOrFail($request->id)->name;
        // $compact[1]['title'] =  "المشروعات";
        // $compact[1]['url'] = route('companies.index');
        // $compact[2]['title'] =   "الفروع";
        // $compact[2]['url'] = "javascript:void(0);";

        // $compact["view"] = "cats.index";

        //  $data = Category::with('products')->where('company_id',$request->company_id)->get();
        // return return_res($data, $compact ,\App\Http\Resources\Api\CategoryResource::class);
return response()->json([
    'success' => true,
    'message' => 'تم الاضافة  بنجاح'
    
]);



    }

    public function show($id)
    {
        $data = $this->repo->show($id);

        $compact[1]['title'] =  "المشروعات";
        $compact[1]['url'] = route('companies.index');
        $compact[2]['title'] =   "الفروع";
        $compact[2]['url'] = "javascript:void(0);";

        $compact["view"] = "cats.index";

        return return_res($data, $compact ,\App\Http\Resources\Api\CategoryResource::class);
        
    }
    public function edit(Category $category)
    {
        //
    }
    public function update(UpdateCategoryRequest $request, $id)
{
    // لو الطلب AJAX → نرجع JSON
    if ($request->ajax() || $request->wantsJson()) {
        $this->repo->update($request, $id);

        return response()->json([
            'success' => true,
            'message' => 'تم التعديل بنجاح'
        ]);
    }

    // لو طلب عادي (مش AJAX) → نرجع redirect عادي
    $this->repo->update($request, $id);
    return redirect()->back()->with('success', 'تم التعديل بنجاح');
}
    public function destroy($id)
    {
        $this->repo->destroy($id);
        return redirect()->back()->with('success','تم الحذف بنجاح');

        // $data =  Category::with('products')->where('company_id',request()->company_id)->get();
        // // dd($data);
        // $company_name = Company::findOrFail(request()->get('id'))->name;
        // $compact[1]['title'] =  "المشروعات";
        // $compact[1]['url'] = route('companies.index');
        // $compact[2]['title'] =   "الفروع";
        // $compact[2]['url'] = "javascript:void(0);";

        // $compact["view"] = "cats.index";

        // return return_res($data, $compact ,\App\Http\Resources\Api\CategoryResource::class);
    }
}
