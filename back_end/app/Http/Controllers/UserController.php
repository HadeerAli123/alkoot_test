<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\UserInterface;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UserLoginRequest;
use App\Models\User;
class UserController extends Controller
{


    protected $repo;
    public function __construct(UserInterface $repo)
    {
        $this->repo = $repo;
    }


    public function login(UserLoginRequest $request)
    {
        $data = $this->repo->login($request);
    //   $compact[1]['title'] =  "الرئيسية";
     //   $compact[1]['url'] = "javascript:void(0);";
         $compact["view"] = "index";
         if ($data) {
             $user = auth()->user();
             return return_res($user, $compact, null);
         } else {
             return back()->withErrors([
                 'login' => 'اسم المستخدم أو كلمة المرور غير صحيحة.',
             ])->withInput();
         }
    }

    public function store(StoreUserRequest $request)
    {
         $data = $this->repo->store($request);
         return redirect()->back()->with('تم  الاضافة بنجاح');
        //  $compact[1]['title'] =  "المستخدمين";
        //  $compact[1]['url'] = "javascript:void(0);";
        //  $compact["view"] = "users";

        // //  dd(auth()->user());

        // return return_res($data, $compact , null);
    }

     public function index()
    {

         $data =  $this->repo->index();
         $compact[1]['title'] =  "المستخدمين";
         $compact[1]['url'] = "javascript:void(0);";
         $compact["view"] = "users";

        //  dd(auth()->user());

        return return_res($data, $compact , null);
    }

    public function create()
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {

    }

    public function update(UpdateUserRequest $request, $id)
    {
        
        $user = User::find($id);
        if (!$user) {
            return return_res(null, [], 'المستخدم غير موجود.');
        }

        // Check if the username is taken by another user
        $exists = User::where('username', $request->username)
            ->where('id', '!=', $id)
            ->exists();

        if ($exists) {
            return return_res(null, [], 'اسم المستخدم مستخدم بالفعل.');
        }

        $data = $request->only(['name', 'username', 'email']);
        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $user->update($data);

        return redirect()->back()->with('تم التعديل بنجاح');
        // $compact[1]['title'] = "المستخدمين";
        // $compact[1]['url'] = "javascript:void(0);";
        // $compact["view"] = "users";

        // return return_res($user, $compact, null);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        // Delete related setting if exists

        $user->delete();
        return redirect()->back()->with('تم الحذف بنجاح');

        // return redirect()->route('companies.index')-
    }
    public function logout()
    {
        return $this->repo->logout();
    }
    public function login_page()
    {
        return $this->repo->login_page();

    }

}
