<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface CompanyInterface
{


    public function index(Request $request);

    public function getdata();

    public function show($id);

    public function create();

    public function store(Request $data);

    public function destroy($id);
}
