<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface AdsInterface
{


    public function index(Request $request);

    public function getdata();

    public function show($id);

    public function create();

    public function store(StoreAdsRequest $data);

    public function update(Request $request,$id);

    public function destroy($id);

    public function getAll(Request $request);

}
