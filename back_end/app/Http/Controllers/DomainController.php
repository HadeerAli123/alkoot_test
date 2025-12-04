<?php

namespace App\Http\Controllers;

use App\Models\Domain;
use App\Interfaces\DomainInterface;
use App\Http\Requests\StoreDomainRequest;
use App\Http\Requests\UpdateDomainRequest;

class DomainController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $repo;
    public function __construct(DomainInterface $repo)
    {
        $this->repo = $repo;
    }
    public function index()
    {
         $data = $this->repo->index();

         $compact[1]['title'] = "النطاقات";
         $compact[1]['url'] = route('domain.index');
         $compact[1]['icon'] = "fa fa-building";
         $compact["view"] = "domains";
        return return_res($data, $compact ,null);
    }

    public function getdata()
    {
         return $this->repo->getdata();
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
    public function store(StoreDomainRequest $request)
    {
        $this->repo->store($request);
        return redirect()->route('domain.index')->with('success','تم الاضافة بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $data = $this->repo->show($id);

         $compact[1]['title'] = "النطاقات";
         $compact[1]['url'] = route('domain.index');
         $compact["view"] = "domains";

        return return_res($data, $compact ,null);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Domain $domain)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDomainRequest $request, $id)
    {
        //
        $this->repo->update($request, $id);
        return redirect()->back()->with('success','تم التعديل بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
         $this->repo->destroy($id);
        return redirect()->back()->with('success','تم الحذف بنجاح');
    }
}
