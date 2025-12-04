<?php

use Carbon\Carbon;
use App\Models\Domain;
use Illuminate\Database\Eloquent\Collection;


if (!function_exists('new_asset')) {
    function new_asset($path)
    {
        return asset($path);
    }
}
if (!function_exists('return_res')) {
    function return_res($data, $compact ,$resource)
    {

           $domain = Domain::all();

        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route('home');

        for($i=1; $i <= count($compact)-1 ;$i++)
        {
            if (isset($compact[$i]['title']) && isset($compact[$i]['url'])) {
                $breadcrumb[] = [
                    'title' => $compact[$i]['title'],
                    'url' => $compact[$i]['url']
                ];
            }
        }


        $view = $compact["view"];

        if (request()->wantsJson() && $resource != null)  // Check if the request wants JSON and a resource is provided
        {

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
        else
            return view('layout', compact( 'view', 'breadcrumb', 'data' ,'domain'));

    }
}

if (!function_exists('UploadImage')) {
    function UploadImage($path, $file)
    {
        $filename = time() . '-' . uniqid() . '.' . $file->getClientOriginalExtension();
        $f = $path . '/' . $filename;
        try
        {
            $file->move(public_path($path), $filename);
            return $f;
        }
        catch (\Exception $e) {
            dd('Upload Failed: ' . $e->getMessage());
        }
    }
}


if (!function_exists('format_number')) {
    function format_number($number, $decimals = 3, $decimal_separator = '.', $thousands_separator = ',')
    {
        return number_format($number, $decimals, $decimal_separator, $thousands_separator);
    }
}


if (!function_exists('formatTime')) {
    function formatTime($time)
    {
        if (!preg_match('/^\d{2}:\d{2}:\d{2}$/', $time)) {
            return '';
        }
        $to = Carbon::createFromFormat('H:i:s', $time)->format('h:i A');
        $toDay = str_replace(['AM', 'PM'], ['ص', 'م'], $to);
        return $toDay;
    }
}
