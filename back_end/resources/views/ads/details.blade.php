<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
<link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
<style>
.theme-input-style {
    width: 100%;
    padding: 10px 12px;
    border: 1.5px solid #ccc !important;
    border-radius: 8px;
    font-size: 14px;
    box-sizing: border-box;
    transition: border-color 0.3s ease;
}

.theme-input-style:focus {
    border-color: #4a57f5;
    outline: none;
}
</style>
<div class="row">
    <div class="col-12">
        <div class="card mb-30 radius-20">
            <div class="card-body pt-30">
                <h6 class="font-15 "> احصائيات الحملة</h6>
                <div class="col-md-3" style="float: inline-end;">
                    <form method="GET" action="{{ route('ads_details.index') }}"
                        class="d-flex align-items-center justify-content-end mb-3">
                        <label for="dateSelect" class="me-2 mb-0 fw-bold" style="white-space: nowrap;">
                            <i class="fa fa-calendar-alt me-1"></i> اختر التاريخ:
                        </label>
                        &nbsp;&nbsp;
                        <select class="form-control select-date rounded-pill shadow-sm theme-input-style"
                            id="dateSelect" name="month"
                            style="min-width: 140px; margin-left: 10px; font-size: 14px; height: 48px;"
                            onchange="this.form.submit()">
                            <option selected disabled>اختر التاريخ</option>
                            @php
                            use Carbon\Carbon;
                            $dates = [];
                            $now = Carbon::now();
                            $dates[] = $now->format('Y-m');
                            for ($i = 1; $i <= 24; $i++) { $dates[]=$now->copy()->subMonths($i)->format('Y-m');
                                }
                                @endphp
                                @foreach ($dates as $date)
                                <option value="{{ $date }}" {{ request()->get('month') == $date ? 'selected' : '' }}>
                                    {{ $date }}
                                </option>
                                @endforeach
                        </select>
                        <input type="hidden" name="ads_id" value="{{ request()->get('ads_id') }}">
                    </form>
                </div>
                <br>
                <br>

                <div class="table-responsive">
                    <!-- Invoice List Table -->
                    <table class="text-nowrap bg-white dh-table">
                        <thead class="thead-light">
                            <tr>
                                <th>اليوم </th>
                                <th>سعر اليوم</th>
                                <th>عدد الزيارات </th>
                                <th>عدد ضغطات الاتصال </th>
                                <th>عدد ضغطات الواتساب </th>
                                <th>عدد ضغطات الانستجرام </th>
                                <th>عدد ضغطات جوجل ماب </th>
                                <th>عدد ضغطات جوجل ماب 2</th>
                                <th>عدد ضغطات قائمة الطعام </th>
                            </tr>
                        </thead>

                       
                        @php
                        $totalPhoneCount =0 ; $totalvisitCount =0; $totalwhatsCount =0;$totalinstaCount=0;
                        $totalmapCount=0; $totalmap2Count=0; $totalmenuCount=0;
                        $month = request()->get('month') ?? now()->format('Y-m');
                        $startOfMonth = \Carbon\Carbon::createFromDate($month, 1);
                        $daysInMonth = $startOfMonth->daysInMonth;

                        $ads = \App\Models\Ads::where('id',request()->get('ads_id'))->first();
                        $startDate = \Carbon\Carbon::parse($ads->start_date)->format('Y-m-d');
                        $endDate = \Carbon\Carbon::parse($ads->end_date)->format('Y-m-d');
                        $startDate = Carbon::parse($startDate)->startOfMonth();
                        $endDate = Carbon::parse($endDate)->endOfMonth();
                        $period = \Carbon\CarbonPeriod::create($startDate, $endDate);
                        @endphp
                        @if (!empty($period) && count($data) > 0)
                        <tbody>
@foreach ($period as $date)
@php
    $today = \Carbon\Carbon::today()->format('Y-m-d');
    $currentDate = $date->format('Y-m-d');

    $visitCount = \App\Models\Details::where('ads_id', request()->get('ads_id'))
        ->where('type', 'visit')
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

    $phoneCount = \App\Models\Details::where('ads_id', request()->get('ads_id'))
        ->where('type', 'phone')
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

    $menuCount = \App\Models\Details::where('ads_id', request()->get('ads_id'))
        ->where('type', 'menu')
        ->where('date', $date)
        ->sum('count');

    $totalPhoneCount += $phoneCount;
    $totalvisitCount += $visitCount;
    $totalwhatsCount += $whatsCount;
    $totalmapCount += $mapCount;
    $totalinstaCount += $instaCount;
    $totalmenuCount += $menuCount;
    $totalmap2Count += $map2Count;
@endphp

@php
    $isToday = $date->isToday(); // علشان نعرف هل التاريخ ده هو تاريخ النهارده
@endphp

<tr @if($isToday) style="background-color: #e3f2fd; font-weight: bold;" @endif>
    <td>
        {{ $date->format('Y-m-d') }}
        @if($isToday)
            <span style="color:#1976d2; font-weight:bold;">(اليوم)</span>
        @endif
    </td>
    <td>{{ optional($ads)->amount_per_day ?? '' }}</td>
    <td>
        <a href="{{ route('details.visits',['ads_id' => request()->get('ads_id'),'date' => $date->format('Y-m-d') ]) }}" class="text-primary">
            {{ $visitCount }}
        </a>
    </td>
    <td>{{ $phoneCount }}</td>
    <td>{{ $whatsCount }}</td>
    <td>{{ $instaCount }}</td>
    <td>{{ $mapCount }}</td>
    <td>{{ $map2Count }}</td>
    <td>{{ $menuCount }}</td>
</tr>
@endforeach


                        </tbody>
                        <tfoot>
                            <tr style="border-top:1px solid">
                                <td>الاجمالى</td>
                                <td>-</td>
                                <td>{{ $totalvisitCount }}</td>
                                <td>{{ $totalPhoneCount }}</td>
                                <td>{{ $totalwhatsCount }}</td>
                                <td>{{ $totalinstaCount }}</td>
                                <td>{{ $totalmapCount }}</td>
                                <td>{{ $totalmap2Count }}</td>
                                <td> {{ $totalmenuCount }}</td>
                            </tr>
                        </tfoot>
                        @endif
                    </table>
                    <!-- End Invoice List Table -->
                </div>
            </div>
        </div>

    </div>
</div>