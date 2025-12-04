<?php

namespace App\Http\Controllers;

use App\Models\Ads;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;


use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;

class QrCodeController extends Controller
{
    /**
     * Generate and display a QR Code.
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function generate($ad_id=null)
    {
        $ads = Ads::all();
      
        $destinationPath = public_path('qr_codes');
        if (!File::exists($destinationPath)) {
            File::makeDirectory($destinationPath, 0755, true);
        }
  
        foreach ($ads as $ad) {
             $domain = $ad->company->domains?->url ?? '';
             if (!$domain) {
                return 'لا يوجد رابط';
            } else {
                $domain = rtrim($domain, '/');
                if (!preg_match('/^https?:\/\//', $domain)) {
                    $domain = 'http://' . $domain;
                }
                $url = $domain . '/' . $ad->id;
            }
            if($ad->qr_code == '' && $ad->id != $ad_id)
                {

                    $qrCode = new QrCode($url);
                    $qrCode->setSize(300);
                    $qrCode->setMargin(10);
                    $writer = new PngWriter();
                    $qrImage = $writer->write($qrCode);

                    $filename = md5(uniqid()) . '.png';
                    $filepath = public_path('qr_code/' . $filename);

                    if (!file_exists(public_path('qr_code'))) {
                        mkdir(public_path('qr_code'), 0755, true);
                    }

                    $qrImage->saveToFile($filepath);

                    DB::table('ads')->where('id', $ad->id)->update(['qr_code' => "qr_code/{$filename}"]);
                }
            if($ad->id == $ad_id)
               {
                    $ad_new = Ads::findorfail($ad_id); 
                    // $data = route('ads_.edit', Crypt::encryptString($ad_new->id));

                    $qrCode = new QrCode($url);
                    $qrCode->setSize(300);
                    $qrCode->setMargin(10);

                    $writer = new PngWriter();
                    $qrImage = $writer->write($qrCode);

                    $filename = md5(uniqid()) . '.png';
                    $filepath = public_path('qr_code/' . $filename);

                    if (!file_exists(public_path('qr_code'))) {
                        mkdir(public_path('qr_code'), 0755, true);
                    }

                    $qrImage->saveToFile($filepath);
                    DB::table('ads')->where('id', $ad_new->id)->update(['qr_code' => "qr_code/{$filename}"]);
            }
    }
        return redirect()->back()->with('success', 'تم الإضافة  بنجاح');
    }
    public function download($ad_id)
    {
        $ad = Ads::findOrFail($ad_id);

        if (!$ad->qr_code_path || !File::exists(public_path($ad->qr_code_path))) {
            return response()->json(['error' => 'QR Code not found.'], 404);
        }

        $filePath = public_path($ad->qr_code_path);

        return response()->download($filePath, "ad-{$ad->name_ar}-qr-code.png");
    }

}
