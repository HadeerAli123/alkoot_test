<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface CategoryInterface
{


    public function index(Request $request);

    public function getdata();

    public function show($id);

    public function create();

    public function store(StoreCategoryRequest $data);

    public function update(UpdateCategoryRequest $request, $category_id);

    public function destroy($id);
}
