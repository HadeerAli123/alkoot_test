<?php

namespace App\Repositories;

use App\Interfaces\CategoryInterface;
use App\Models\Category;

use Illuminate\Http\Request;
use App\Models\SocialMedia;


class CategoryRepository implements CategoryInterface
{
    // public function index(Request $request)
    // {
    //     // dd("dd");
    //     return Category::with('products')->where('company_id',$request->id)->get();
    // }
     public function index(Request $request)
    {

        return Category::with('company')->when($request->id , function ($query) use ($request) {
                                $query->where('company_id', $request->id );
                        })
                     ->get();

    }


    public function getdata()
    {
    }

       public function show($slug)
    {
        return Category::with('products')->where('slug', $slug)
        ->firstOrFail();
    }

    public function create()
    {
    }
    public function store($request)
    {

            $new = new Category();
            $new->name = $request->name;
            $new->company_id = $request->company_id;
            $new->description = $request->description ?? null;
            if ($request->hasFile('menu')) {
                $menu = UploadImage('category/menu', $request->menu);
            }
           
            $new->save();

             if ($new) {
                if ($request->has('whatsapp')) {
                    $social = new SocialMedia();
                    $social->cat_id = $new->id;
                    $social->type = "whatsapp";
                    $social->link = $request->whatsapp;
                    $social->save();
                }
                if ($request->has('google_Map')) {
                    $social = new SocialMedia();
                    $social->cat_id = $new->id;
                    $social->type = "google_Map";
                    $social->link = $request->google_Map;
                    $social->save();
                }
                if ($request->has('google_Map_2')) {
                    $social = new SocialMedia();
                    $social->cat_id = $new->id;
                    $social->type = "google_Map_2";
                    $social->link = $request->google_Map_2;
                    $social->save();
                }
                if ($request->has('instagram')) {
                    $social = new SocialMedia();
                    $social->cat_id = $new->id;
                    $social->type = "instagram";
                    $social->link = $request->instagram;
                    $social->save();
                }
                if ($request->has('phone')) {
                    $social = new SocialMedia();
                    $social->cat_id = $new->id;
                    $social->type = "phone";
                    $social->link = $request->phone;
                    $social->save();
                }
                if ($request->hasFile('menu')) {
                    $social = new SocialMedia();
                    $social->cat_id = $new->id;
                    $social->type = "menu";
                    $social->link = $menu ?? null;
                    $social->save();
                }

            }

           return $new;
    }
    public function update($request,$category_id)
    {
            $new = Category::with('products')->findOrFail($category_id);
            $new->name = $request->name;
            $new->description = $request->description;
             if ($request->hasFile('menu')) {
                $menu = UploadImage('category/menu', $request->menu);
            }
            $new->save();

            if ($new) {
            if ($request->has('whatsapp')) {
                SocialMedia::where('cat_id', $category_id)
                            ->where('type', 'whatsapp')
                            ->update(['link' => $request->whatsapp]);
            }
            if ($request->has('google_Map')) {
               
               SocialMedia::where('cat_id', $category_id)
                            ->where('type', 'google_Map')
                            ->update(['link' => $request->google_Map]);
            }
            if ($request->has('google_Map_2')) {
               
               SocialMedia::where('cat_id', $category_id)
                            ->where('type', 'google_Map_2')
                            ->update(['link' => $request->google_Map_2]);
            }
            if ($request->has('instagram')) {
                 SocialMedia::where('cat_id', $category_id)
                            ->where('type', 'instagram')
                            ->update(['link' => $request->instagram]);
               
            }
            if ($request->has('phone')) {
               SocialMedia::where('cat_id', $category_id)
                            ->where('type', 'phone')
                            ->update(['link' => $request->phone]);
               
            }
            if ($request->hasFile('menu')) {
                SocialMedia::where('cat_id', $category_id)
                            ->where('type', 'menu')
                            ->update(['link' => $menu]);
            }
        }
            return $new;
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        $data =  Category::with('products')->get();
        return $data;
    }

}
