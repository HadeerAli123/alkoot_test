<?php

namespace App\Http\Controllers;

use App\Models\Details;
use App\Http\Requests\StoreDetailsRequest;
use App\Http\Requests\UpdateDetailsRequest;
use App\Interfaces\DetailsInterface;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Ads;

class DetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     protected $repo;
    public function __construct(DetailsInterface $repo)
    {
        $this->repo = $repo;
    }

    public function index(Request $request)
    {
         $this->repo->index($request);
        $id = Ads::findOrFail($request->ads_id)->company_id;
        $compact[1]['title'] =  "المشروعات";
        $compact[1]['url'] = route('companies.index');
        $compact[2]['title'] = "الاعلانات";
        $compact[2]['url'] = route('ads_.index',['comp_id' => $id]);
        $compact[3]['title'] = "الاحصائيات";
        $compact[3]['url'] = "javascript:void(0);";

        $compact["view"] = "ads.details";

        $selectedMonth = $request->input('month') ?? Carbon::now()->format('Y-m');

        $query = Details::with('ads');

        // Filter by selected month
        $query->whereYear('created_at', substr($selectedMonth, 0, 4))
            ->whereMonth('created_at', substr($selectedMonth, 5, 2));

        $data_ = $query->where('ads_id',request()->get('ads_id'))->get(); 

        $data = $data_->groupBy(function ($item) {
            return Carbon::parse($item->date)->toDateString(); // 'YYYY-MM-DD'
        });
    //    dd($data);
        return return_res($data, $compact, \App\Http\Resources\Api\DetailsResource::class);
    }

    public function visit_details(Request $request)
    {
        return $this->repo->visit_details($request);  
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
    public function store(StoreDetailsRequest $request)
    {
        $data = $this->repo->store($request);
        // // dd($data);
        $id = Ads::findOrFail($request->ads_id)->company_id;
        $compact[1]['title'] =  "المشروعات";
        $compact[1]['url'] = route('companies.index');
        $compact[2]['title'] = "الاعلانات";
        $compact[2]['url'] = route('ads_.index',['comp_id' => $id]);
        $compact[3]['title'] = "الاحصائيات";
        $compact[3]['url'] = "javascript:void(0);";

        $compact["view"] = "ads.details";

        return return_res($data, $compact, \App\Http\Resources\Api\DetailsResource::class);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $data = $this->repo->show($id);
        // dd($data);
        $ads_id  = Details::findOrFail($id)->ads_id;
        $id = Ads::findOrFail($ads_id)->company_id;
        $compact[1]['title'] =  "المشروعات";
        $compact[1]['url'] = route('companies.index');
        $compact[2]['title'] = "الاعلانات";
        $compact[2]['url'] = route('ads_.index',['comp_id' => $id]);
        $compact[3]['title'] = "الاحصائيات";
        $compact[3]['url'] = "javascript:void(0);";

        $compact["view"] = "ads.details";

        return return_res($data, $compact, \App\Http\Resources\Api\DetailsResource::class);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Details $details)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDetailsRequest $request, Details $details)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Details $details)
    {
        //
    }


}
