<table class="text-nowrap bg-white dh-table">
    <thead class="thead-light">
        <tr>
            <th>اليوم</th>
            <th>سعر اليوم</th>
            <th>عدد الزيارات</th>
            <th>عدد ضغطات الاتصال</th>
            <th>عدد ضغطات الواتساب</th>
            <th>عدد ضغطات الانستجرام</th>
            <th>عدد ضغطات جوجل ماب</th>
            <th>عدد ضغطات جوجل ماب 2</th>
         <th>عدد ضغطات تيك توك </th>

            <th>عدد ضغطات قائمة الطعام</th>
        </tr>
    </thead>

@php

use Carbon\Carbon;
use Carbon\CarbonPeriod;

/* ===============================
   بيانات الحملة
================================ */
$ads = \App\Models\Ads::where('id', request()->get('ads_id'))->first();

$startDate = Carbon::parse($ads->start_date);
$endDate   = Carbon::parse($ads->end_date);

/* ===============================
   إجمالي قيمة الحملة
================================ */
$campaignDays  = $startDate->diffInDays($endDate) + 1;
$campaignTotal = $campaignDays * $ads->amount_per_day;

/* ===============================
   إجماليات
================================ */
$totalPhoneCount = 0;
$totalvisitCount = 0;
$totalwhatsCount = 0;
$totalinstaCount = 0;
$totalmapCount   = 0;
$totalmap2Count  = 0;
$totaltiktokCount =0;
$totalmenuCount  = 0;

/* ===============================
   فترة العرض (من أول شهر البداية لآخر شهر النهاية)
================================ */
$period = CarbonPeriod::create(
    $startDate->copy()->startOfMonth(),
    $endDate->copy()->endOfMonth()
);

@endphp

<tbody>
@foreach ($period as $date)

@php
    $isInCampaign = $date->between($startDate, $endDate);
    $isToday = $date->isToday();

    $visitCount = \App\Models\Details::where('ads_id', request()->get('ads_id'))
        ->where('type', 'visit')
        ->where('date', $date)
        ->sum('count');

    $phoneCount = \App\Models\Details::where('ads_id', request()->get('ads_id'))
        ->where('type', 'phone')
        ->where('date', $date)
        ->sum('count');

    $whatsCount = \App\Models\Details::where('ads_id', request()->get('ads_id'))
        ->where('type', 'whatsapp')
        ->where('date', $date)
        ->sum('count');

    $instaCount = \App\Models\Details::where('ads_id', request()->get('ads_id'))
        ->where('type', 'instagram')
        ->where('date', $date)
        ->sum('count');

    $mapCount = \App\Models\Details::where('ads_id', request()->get('ads_id'))
        ->where('type', 'google_Map')
        ->where('date', $date)
        ->sum('count');

    $map2Count = \App\Models\Details::where('ads_id', request()->get('ads_id'))
        ->where('type', 'google_Map_2')
        ->where('date', $date)
        ->sum('count');
      $tiktokCount = \App\Models\Details::where('ads_id', request()->get('ads_id'))
        ->where('type', 'tiktok')
        ->where('date', $date)
        ->sum('count');

    $menuCount = \App\Models\Details::where('ads_id', request()->get('ads_id'))
        ->where('type', 'menu')
        ->where('date', $date)
        ->sum('count');

    $totalvisitCount += $visitCount;
    $totalPhoneCount += $phoneCount;
    $totalwhatsCount += $whatsCount;
    $totalinstaCount += $instaCount;
    $totalmapCount   += $mapCount;
    $totalmap2Count  += $map2Count;
    $totaltiktokCount  += $tiktokCount;
    $totalmenuCount  += $menuCount;
@endphp

<tr @if($isToday) style="background:#e3f2fd;font-weight:bold" @endif>
    <td>
        {{ $date->format('Y-m-d') }}
        @if($isToday)
            <span style="color:#1976d2">(اليوم)</span>
        @endif
    </td>

    <td>
        @if($isInCampaign)
            {{ $ads->amount_per_day }}
        @else
            -
        @endif
    </td>

    <td>
        <a href="{{ route('details.visits',['ads_id'=>request()->get('ads_id'),'date'=>$date->format('Y-m-d')]) }}" class="text-primary">
            {{ $visitCount }}
        </a>
    </td>

    <td>{{ $phoneCount }}</td>
    <td>{{ $whatsCount }}</td>
    <td>{{ $instaCount }}</td>
    <td>{{ $mapCount }}</td>
    <td>{{ $map2Count }}</td>
        <td>{{ $tiktokCount }}</td>

    <td>{{ $menuCount }}</td>
</tr>
@endforeach
</tbody>

<tfoot>
<tr style="border-top:2px solid #000;font-weight:bold">
    <td>الإجمالي</td>
    <td>{{ $campaignTotal }}</td>
    <td>{{ $totalvisitCount }}</td>
    <td>{{ $totalPhoneCount }}</td>
    <td>{{ $totalwhatsCount }}</td>
    <td>{{ $totalinstaCount }}</td>
    <td>{{ $totalmapCount }}</td>
    <td>{{ $totalmap2Count }}</td>
        <td>{{ $totaltiktokCount }}</td>

    <td>{{ $totalmenuCount }}</td>
</tr>
</tfoot>

</table>
