<?php

namespace App\Http\Controllers;

use App\Models\Ads;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Interfaces\AdsInterface;
use App\Http\Requests\StoreAdsRequest;
use App\Http\Requests\UpdateAdsRequest;
use Illuminate\Database\Eloquent\Collection;

class AdsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $repo;
    public function __construct(AdsInterface $repo)
    {
        $this->repo = $repo;
    }
    public function index(Request $request)
    {

          $this->repo->index($request);
        $compact[1]['title'] =  "المشروعات";
        $compact[1]['url'] = route('companies.index');
         $compact[2]['title'] = "الحملات الاعلانية";
         $compact[2]['url'] = "javascript:void(0);";

        $compact["view"] = "ads.index";

        $data =  Ads::with('company')->where('company_id', $request->comp_id)->get();
        return return_res($data, $compact, \App\Http\Resources\Api\AdsResource::class);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAdsRequest $request)
    {
        $data = $this->repo->store($request);
        
        return redirect()->to('qr-code/generate/'.$data->id);

        // return redirect()->back()->with('success','تم الاضافة بنجاح');

        // $compact[1]['title'] =  "المشروعات";
        // $compact[1]['url'] = route('companies.index');
        // // $compact[2]['title'] = "الاعلانات";
        // // $compact[2]['url'] = "javascript:void(0);";

        // $compact["view"] = "ads.index";
        // $data =  Ads::with('company')->where('company_id', $request->company_id)->get();
        // return return_res($data, $compact, \App\Http\Resources\Api\AdsResource::class);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {

        $data = $this->repo->show($id);
        $compact[1]['title'] =  "المشروعات";
        $compact[1]['url'] = route('companies.index');
        // $compact[2]['title'] = "الاعلانات";
        // $compact[2]['url'] = "javascript:void(0);";

        // dd($data);
    //    $resource= \App\Http\Resources\Api\AdsResource::class;

        //  $res = $data instanceof Collection || is_array($data)
        //         ? $resource::collection($data)
        //         : new $resource($data);
        //     if (!$res) {
        //         return response()->json([
        //             'code' => 404,
        //             'message' => 'No data found',
        //             'data' => null,

        //         ], 200);
        //     }
        //     return response()->json([
        //         'code' => 200,
        //         'message' => 'Success',
        //         'data' => $res,
        //     ]);


        // $compact['title'] = "الاعلانات";
        $compact["view"] = "ads.index";

        return return_res($data, $compact, \App\Http\Resources\Api\AdsResource::class);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // dd($id);
        
        $compact[1]['title'] =  "المشروعات";
        $compact[1]['url'] = route('companies.index');
        $compact[2]['title'] = "الاعلانات";
        $compact[2]['url'] = "javascript:void(0);";

        $compact["view"] = "ads.edit";
                
        $data =  Ads::findORFail($id);

        return return_res($data, $compact, \App\Http\Resources\Api\AdsResource::class);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAdsRequest $request,$id)
    {

        $this->repo->update($request,$id);
        return redirect()->back()->with('success','تم التعديل بنجاح');
        // $compact[1]['title'] =  "المشروعات";
        // $compact[1]['url'] = route('companies.index');
        // $compact[2]['title'] = "الاعلانات";
        // $compact[2]['url'] = "javascript:void(0);";

        // $compact["view"] = "ads.index";
        // $data =  Ads::with('company')->where('company_id', $request->company_id)->get();
        // return return_res($data, $compact, \App\Http\Resources\Api\AdsResource::class);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {

        $this->repo->destroy($id);
        return redirect()->back()->with('success','تم الحذف بنجاح');

        //  $compact[1]['title'] =  "المشروعات";
        // $compact[1]['url'] = route('companies.index');
        // $compact[2]['title'] = "الاعلانات";
        // $compact[2]['url'] = "javascript:void(0);";

        // $compact["view"] = "ads.index";
        // $data =  Ads::with('company')->where('company_id', request()->get('comp_id'))->get();
        // return return_res($data, $compact, \App\Http\Resources\Api\AdsResource::class);
    }

    public function getAll(Request $request)
    {
        $data =  $this->repo->getAll($request);
        // dd(count($data));
        $compact[1]['title'] =  "الحملات الاعلانية";
        $compact[1]['url'] = "javascript:void(0);";

        $compact["view"] = "ads.all_ads";
        return return_res($data, $compact, \App\Http\Resources\Api\AdsResource::class);
    }

    public function getData()
    {
        return $this->repo->getData();
    }
public function startNow($id){
    return $this->repo->startNow($id);
}

}
