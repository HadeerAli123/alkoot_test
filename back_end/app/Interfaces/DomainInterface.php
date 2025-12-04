<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface DomainInterface
{


    public function index();

    public function getdata();

    public function show($id);

    public function create();
    public function update(Request $data ,$id);

    public function store(Request $data);

    public function destroy($id);
}
