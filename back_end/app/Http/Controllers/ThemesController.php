<?php

namespace App\Http\Controllers;

use App\Models\SocialMedia;
use App\Models\Theme;
use Illuminate\Database\Eloquent\Collection;

class ThemesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Theme::all();
        $resource = \App\Http\Resources\Api\ThemesResource::class;
        $res = $data instanceof Collection || is_array($data)
                ? $resource::collection($data)
                : new $resource($data);
            if (!$res) {
                return response()->json([
                    'code' => 404,
                    'message' => 'No data found',
                    'data' => null,

                ], 200);
            }
            return response()->json([
                'code' => 200,
                'message' => 'Success',
                'data' => $res,
            ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSocialMediaRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(SocialMedia $socialMedia)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SocialMedia $socialMedia)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSocialMediaRequest $request, SocialMedia $socialMedia)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SocialMedia $socialMedia)
    {
        //
    }
}
