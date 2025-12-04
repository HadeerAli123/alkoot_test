<?php

namespace App\Repositories;

use App\Interfaces\DetailsInterface;
use App\Models\Details;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Ads;

class DetailsRepository implements DetailsInterface
{
    public function index(Request $request)
    {
        return Details::with('ads')->where('ads_id',$request->ads_id)->get();
    }

    public function getdata() {}

    public function show($id)
    {
        return Details::GroupBy('ads_id')->find($id);
    }

    public function create() {}
    public function store($request)
    {
        // $data = Details::updateOrCreate(
        //     [
        //         'date' => Carbon::now()->format('Y-m-d'),
        //         'product_id' => $request->product_id,
        //         'type' => $request->type,
        //         'ads_id' => $request->ads_id,
        //     ], // If $id exists, update. Otherwise create.
        //     [
        //         'type' => $request->type,
        //         'date' => Carbon::now()->format('Y-m-d'),
        //         'product_id' => $request->product_id,
        //         'ads_id' => $request->ads_id,
        //         'count' => 1,

        //     ]
        // );

        // if (!$data->wasRecentlyCreated) {
        //     $data->increment('count');
        // }
        $product = null;
        $cat=null;
        if($request->has('product_id')) {
            $product =  $request->product_id;
        }
        if($request->has('cat_id')) {
            $cat =  $request->cat_id;
        }

        $data = Details::firstOrNew([
            'date' => Carbon::now()->format('Y-m-d'),
            'product_id' => $product,
            'cat_id' => $cat,
            'type' => $request->type,
            'ads_id' => $request->ads_id,
            // 'created_by' => Auth::user()->id,
            // 'updated_by' => Auth::user()->id,
        ]);

        $data->count = $data->exists ? $data->count + 1 : 1;
        $data->save();

        return $data;
    }

    public function delete($id) {}

    public function visit_details($request)
    {
        $comp_id = Ads::with('products')->where('id', $request->ads_id)->first()->company_id;
       
        $compact[1]['title'] =  "المشروعات";
        $compact[1]['url'] = route('companies.index');
        $compact[2]['title'] = "الاعلانات";
        $compact[2]['url'] = route('ads_.index',['comp_id' => $comp_id]);
        $compact[3]['title'] = "الاحصائيات";
        $compact[3]['url'] = route('ads_details.index',['ads_id' => $request->ads_id]);
        $compact[4]['title'] = "الزيارات";
        $compact[4]['url'] = "javascript:void(0);";

        $compact["view"] = "ads.visit_details";
        $selectedMonth = $request->date ;

        $query = Details::with('product','ads','ads.prods','ads.category')
                         ->where('type','visit')->where('ads_id',request()->get('ads_id'))
                         ->where('date', $selectedMonth);

        $data = $query->get(); 

        return return_res($data, $compact, \App\Http\Resources\Api\DetailsResource::class);
    }
}
