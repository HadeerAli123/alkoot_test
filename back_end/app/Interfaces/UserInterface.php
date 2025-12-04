<?php

namespace App\Interfaces;

use Illuminate\Http\Request;
use App\Http\Requests\StoreUserRequest; // <--- هنا صح

interface UserInterface
{

    public function login(Request $request);

    public function index();

    public function getdata();

    public function show($id);

    public function create();

public function store(StoreUserRequest $request);
    public function delete($id);
    public function logout();
    public function login_page();
}
