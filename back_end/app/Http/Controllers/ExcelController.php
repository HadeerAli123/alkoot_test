<?php

namespace App\Http\Controllers;

use App\Imports\ExcelImport;
use App\Models\Excel as ModelsExcel;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Ads;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Exports\AdsExport;

class ExcelController extends Controller
{
     public function uploadForm()
    {
          $data = ModelsExcel::all();
        $compact['title'] = "الاعلانات";
        $compact["view"] = "upload";
           $compact[1]['title'] =  "المشروعات";
        $compact[1]['url'] = route('companies.index');
         $compact[2]['title'] = "الحملات الاعلانية";
         $compact[2]['url'] = "javascript:void(0);";
        $compact[3]['title'] = "ملفات الاكسيل";

        $compact[3]['icon'] = "fa fa-file-excel";
        $compact[3]['url'] = route('excel.files');
        // $data =  Ads::with('company')->where('company_id', $request->comp_id)->get();
        return return_res($data, $compact, \App\Http\Resources\Api\AdsResource::class);
    }

    public function upload(Request $request)
    {


        $request->validate([
            'file' => 'required|file|max:2048',
        ], [
            'file.required' => 'يرجى رفع ملف.',
            'file.file' => 'الملف غير صالح.',
            'file.mimes' => 'صيغة الملف يجب أن تكون xlsx أو csv أو xls.',
            'file.max' => 'حجم الملف يجب ألا يتجاوز 2 ميجابايت.',
        ]);

        if ($request->hasFile('file')) {
            Excel::import(new ExcelImport, $request->file('file'));
        } else {
            return redirect()->back()->withErrors(['file' => 'يرجى رفع ملف صالح.']);
        }

        return redirect()->back()->with('success', 'تم الاستيراد  بنجاح!');
    }

    public function excelExport($id)
    {
        return Excel::download(new AdsExport($id), 'campaign.xlsx');
    }
}
