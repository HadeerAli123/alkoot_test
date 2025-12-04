<?php
namespace App\Exports;

use App\Models\Ads;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\Category;
use App\Models\Product;


class AdsExport implements FromCollection, WithHeadings
{
    protected $id;

    public function __construct($id = null)
    {
        $this->id = $id;
    }
    public function collection()
    {
        $query = Ads::with(['category', 'company', 'prods']);

        if ($this->id != 'all') {
            $query->where('id', $this->id);
        }

        $adsAll = $query->get();
        $rows = collect();

        foreach ($adsAll as $ads) {
            $adId = $ads->id;
            $start = \Carbon\Carbon::parse($ads->start_date);
            $end = \Carbon\Carbon::parse($ads->end_date);
            
            $start = \Carbon\Carbon::parse($start)->startOfMonth();
            $end = \Carbon\Carbon::parse($end)->endOfMonth();

            $details = \App\Models\Details::select('date', 'type', \DB::raw('SUM(count) as total'))
                ->where('ads_id', $adId)
                ->groupBy('date', 'type')
                ->get()
                ->groupBy('date');

            for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
                $day = $date->toDateString();
                $group = $details->get($day, collect());

                $rows->push([
                    'ad_name'     => $ads->name,
                    'date'        => $day,
                    'price'       => $ads->amount_per_day,
                    'visitsCount' => $group->firstWhere('type', 'visit')?->total ?? 0,
                    'phoneCount'  => $group->firstWhere('type', 'phone')?->total ?? 0,
                    'whatsCount'  => $group->firstWhere('type', 'whatsapp')?->total ?? 0,
                    'instaCount'  => $group->firstWhere('type', 'instagram')?->total ?? 0,
                    'mapCount'    => $group->firstWhere('type', 'google_Map')?->total ?? 0,
                    'map2Count'    => $group->firstWhere('type', 'google_Map_2')?->total ?? 0,
                    'menuCount'   => $group->firstWhere('type', 'menu')?->total ?? 0,
                ]);
            }
        }
        return $rows;
    }

    public function headings(): array
    {
        return [
            'اسم الحملة',
            'التاريخ',
            'السعر',
            'عدد الزيارات',
            'عدد الاتصال',
            'عدد الواتساب',
            'عدد الانستجرام',
            'عدد ضغطات جوجل ماب',
            ' 2 عدد ضغطات جوجل ماب',
            'عدد ضغطات قائمة الطعام',
        ];
    }
}