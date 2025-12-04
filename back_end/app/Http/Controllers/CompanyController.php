<?php

namespace App\Http\Controllers;

use App\Models\Domain;
use App\Models\Company;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Interfaces\CompanyInterface;
use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Http\Resources\Api\CompanyResource;


class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $repo;
    public function __construct(CompanyInterface $repo)
    {
        $this->repo = $repo;
    }
    public function index(Request $request)
    {
        // dd('dddddddd');
    //    $data = $this->repo->getdata();
         $data = $this->repo->index($request);
      


         $compact[1]['title'] = "المشروعات";
         $compact[1]['url'] = route('companies.index');
         $compact[1]['icon'] = "fa fa-building";
         $compact["view"] = "vendors.index";

        return return_res($data, $compact ,\App\Http\Resources\Api\CompanyResource::class);
    }

    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {


         $compact[1]['title'] = "المشروعات";
         $compact[1]['url'] = route('companies.index');
            $compact[2]['title'] = "اضافة مشروع";
            $compact[2]['url'] = "javascript:void(0);";
         $compact["view"] = "vendors.create";

         return return_res($data=null, $compact ,\App\Http\Resources\Api\CompanyResource::class);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCompanyRequest $request)
    {


        $this->repo->store($request);
        return redirect()->route('companies.index')->with('success','تم الاضافة بنجاح');

        // $data =  Company::with('setting')->get();

        // $compact[1]['title'] = "المشروعات";
        // $compact[1]['url'] = route('companies.index');
        // $compact["view"] = "vendors.index";

        // return return_res($data, $compact ,\App\Http\Resources\Api\CompanyResource::class);
    }
    public function show($id)
    {
         $data = $this->repo->show($id);

         $compact[1]['title'] = "المشروعات";
         $compact[1]['url'] = route('companies.index');
         $compact["view"] = "vendors.index";

        return return_res($data, $compact ,\App\Http\Resources\Api\CompanyResource::class);
    }
    public function edit($id)
    {
        //
    }

    public function update(UpdateCompanyRequest $request, $id)
    {
        // dd($request->all());

        $this->repo->update($request, $id);
        return redirect()->back()->with('success','تم التعديل بنجاح');

        // $data =  Company::with('setting')->get();
        // // dd($data);
        //  $compact[1]['title'] = "المشروعات";
        //  $compact[1]['url'] = route('companies.index');
        // $compact["view"] = "vendors.index";

        // return return_res($data, $compact ,\App\Http\Resources\Api\CompanyResource::class);

    }

    /**
     * Remove the specified resource from storage.
     */
public function destroy($id)
{
    $this->repo->destroy($id);
    return redirect()->back()->with('success','تم الحذف بنجاح');
}

    public function checkData($comp_id)
    {
        $comp = Company::findOrFail($comp_id);
        $data =[];
        if($comp->has_branch == 1)
        {
           $data['cats'] =  Category::where('company_id',$comp_id)->get();
        }
       if( $comp->has_product == 1)
       {
          $data['prods'] = Product::where('company_id',$comp_id)->get();
       }
        return $data;
    }

}
