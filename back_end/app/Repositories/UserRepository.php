<?php

namespace App\Repositories;

use App\Models\User;
use App\Interfaces\UserInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserInterface
{

    public function login($request)
    {
        //  dd("ss");
        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {

            return true; // Authentication passed, user is now logged in
        }
       return false;

    }

    public function login_page()
    {
        return view('login');

    }

    public function index()
    {
        return User::all();
    }

    public function getdata() {}

    public function show($id)
    {
        return User::find($id);
    }

    public function create() {}

    public function store($request)
    {

        $new = new User();
        $new->name = $request->name;
        $new->email = $request->email;
        $new->username = $request->username;
        $new->password = Hash::make($request->password);
        $new->save();

        return $new;
    }

    public function delete($id) {}

    public function logout()
    {
        Auth::guard('web')->logout();
        return redirect()->route('login');
    }
}
