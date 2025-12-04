<?php

namespace App\Repositories;

use App\Models\Domain;
use App\Interfaces\DomainInterface;
use App\Models\Setting;
use App\Models\Product;
use App\Models\Category;
use App\Models\SocialMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Yajra\DataTables\DataTables;

class DomainRepository implements DomainInterface
{
    public function index()
    {
        return Domain::all();
    }

    public function getdata()
    {
        $query = Domain::query();

        return DataTables()
            ->eloquent($query)
            ->addIndexColumn()
            ->addColumn('action', function ($item) {
                return '
                    <a href="' . route('domain.edit', $item->id) . '" class="btn btn-primary btn-sm">تعديل</a>
                    <form action="' . route('domain.destroy', $item->id) . '" method="POST" style="display:inline;">
                        ' . csrf_field() . '
                        ' . method_field('DELETE') . '
                        <button type="submit" class="btn btn-danger btn-sm">حذف</button>
                    </form>
                ';
            })
            ->rawColumns(['action'])

        ->make(true);
    }

    public function show($id)
    {
        return Domain::find($id);
    }

    public function create() {}
    public function store($request)
    {
        // dd($request->all());
        $Domain = new Domain();
        $Domain->name = $request->name;
        $Domain->url = $request->url;
        $Domain->save();
        return $Domain;
    }

    public function update($request, $id)
    {
        $new = Domain::find($id);
        $new->name = $request->name;
        $new->url = $request->url;
        $new->save();
        return $new;
    }

    public function destroy($id)
    {

        $Domain = Domain::find($id);
        $Domain->delete();
        $new = Domain::all();
        return $new;
    }
}
