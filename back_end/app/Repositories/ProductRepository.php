<?php

namespace App\Repositories;

use App\Interfaces\ProductInterface;
use App\Models\Product;
use App\Models\SocialMedia;
use Illuminate\Http\Request;

class ProductRepository implements ProductInterface
{
    public function index(Request $request)
    {
        return Product::with('company','socialMedia')->where('company_id',$request->id)->get();
    }

    public function getdata()
    {
    }

    public function show($id)
    {

        return Product::with('socialMedia')->find($id);
    }

    public function create()
    {
    }
    public function store($request)
    {
        $new = new Product();
        $new->name = $request->name;
        $new->location = $request->location ?? null;
        // $new->category_id = $request->cat_id;
        $new->company_id = $request->company_id;

        $new->description = $request->description ?? null;

        $imagePaths = [];

        if ($request->hasFile('images')) {

            foreach ($request->file('images') as $image) {
                $path = UploadImage('product/images', $image); // assuming this saves image and returns path
                $imagePaths[] = url($path);
            }
        }

        $new->image = !empty($imagePaths) ? json_encode($imagePaths) : null;
        $new->save();


        if ($new) {
            if ($request->has('whatsapp')) {
                $social = new SocialMedia();
                $social->product_id = $new->id;
                $social->type = "whatsapp";
                $social->link = $request->whatsapp;
                $social->save();
            }
            if ($request->has('facebook')) {
                $social = new SocialMedia();
                $social->product_id = $new->id;
                $social->type = "facebook";
                $social->link = $request->facebook;
                $social->save();
            }
            if ($request->has('instagram')) {
                $social = new SocialMedia();
                $social->product_id = $new->id;
                $social->type = "instagram";
                $social->link = $request->instagram;
                $social->save();
            }
            if ($request->has('phone')) {
                $social = new SocialMedia();
                $social->product_id = $new->id;
                $social->type = "phone";
                $social->link = $request->phone;
                $social->save();
            }
            if ($request->has('snapchat')) {
                $social = new SocialMedia();
                $social->product_id = $new->id;
                $social->type = "snapchat";
                $social->link = $request->snapchat;
                $social->save();
            }
            if ($request->has('linkedin')) {
                $social = new SocialMedia();
                $social->product_id = $new->id;
                $social->type = "linkedin";
                $social->link = $request->instagram;
                $social->save();
            }
             if ($request->has('website')) {
                $social = new SocialMedia();
                $social->product_id = $new->id;
                $social->type = "website";
                $social->link = $request->instagram;
                $social->save();
            }
             if ($request->has('x')) {
                $social = new SocialMedia();
                $social->product_id = $new->id;
                $social->type = "x";
                $social->link = $request->instagram;
                $social->save();
            }
            if ($request->has('visit')) {
                $social = new SocialMedia();
                $social->product_id = $new->id;
                $social->type = "visit";
                $social->link = $request->link;
                $social->save();
            }
        }
        return $new;
    }

    public function update($request,$id)
    {
         
        $new = Product::with('socialMedia')->findOrFail($id);
        $new->name = $request->name;
        $new->location = $request->location ?? null;
        // $new->category_id = $request->cat_id;
        $new->company_id = $request->company_id;
        $new->description = $request->description ?? null;

        $imagePaths = [];

        if ($request->hasFile('images')) {

            foreach ($request->file('images') as $image) {
                $path = UploadImage('product/images', $image); // assuming this saves image and returns path
                $imagePaths[] = $path;
            }
        }

        $new->image = !empty($imagePaths) ? json_encode($imagePaths) : $new->image;
        $new->save();


        if ($new) {
            if ($request->has('whatsapp')) {
                SocialMedia::where('product_id', $id)
                            ->where('type', 'whatsapp')
                            ->update(['link' => $request->whatsapp]);
            }
            if ($request->has('facebook')) {
               
               SocialMedia::where('product_id', $id)
                            ->where('type', 'facebook')
                            ->update(['link' => $request->facebook]);
            }
            if ($request->has('instagram')) {
                 SocialMedia::where('product_id', $id)
                            ->where('type', 'instagram')
                            ->update(['link' => $request->instagram]);
               
            }
            if ($request->has('phone')) {
               SocialMedia::where('product_id', $id)
                            ->where('type', 'phone')
                            ->update(['link' => $request->phone]);
               
            }
            if ($request->has('snapchat')) {
              SocialMedia::where('product_id', $id)
                            ->where('type', 'snapchat')
                            ->update(['link' => $request->snapchat]);
             
            }
            if ($request->has('linkedin')) {
              
                SocialMedia::where('product_id', $id)
                            ->where('type', 'linkedin')
                            ->update(['link' => $request->linkedin]);
            
            }
             if ($request->has('website')) {
            
              SocialMedia::where('product_id', $id)
                            ->where('type', 'website')
                            ->update(['link' => $request->website]);
            }
             if ($request->has('x')) {

                 SocialMedia::where('product_id', $id)
                            ->where('type', 'x')
                            ->update(['link' => $request->x]);
            }
            if ($request->has('visit')) {

                 SocialMedia::where('product_id', $id)
                            ->where('type', 'visit')
                            ->update(['link' =>  $request->link]);
            }
        }
        return $new;
    }
 

    public function destroy($id)
    {
        $prod = Product::findOrFail($id);
        // Delete related setting if exists
        $social = SocialMedia::where('product_id', $id)->get();

        if ($social) {
            foreach($social as $one)
            {
                $one->delete();
            } 
        }
        $prod->delete();
        $new = Product::with('category','socialMedia')->get();
        return $new;
    }

}
